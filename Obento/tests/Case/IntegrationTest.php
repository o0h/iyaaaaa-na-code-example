<?php

declare(strict_types=1);

namespace O0h\Obento\Tests\Case;

use Cake\Chronos\Chronos;
use O0h\Obento\BentoDB;
use O0h\Obento\BentoOrder;
use O0h\Obento\BentoOrderManager;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function O0h\Obento\Tests\setTestDb;

/**
 * @internal
 */
final class IntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        setTestDb(DB_PATH);
        Chronos::setTestNow('2023-11-10 11:11:10');
    }

    #[Test]
    public function 単体の弁当を注文して、正常に処理が完了する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);

        $orderManager->finalizeOrders();
        $this->expectOutputString(
            '注文が完了しました ID: 1、数量: 1、合計金額: 800円、支払い方法: cash' . \PHP_EOL
        );

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'product_id' => 1,
            'quantity' => 1,
            'customizations' => '[]',
            'price' => 800,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 複数の弁当を注文して、正常に処理が完了する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $order = new BentoOrder(1, 'bento', 1, [], 800, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);
        $order = new BentoOrder(2, 'bento', 1, [], 850, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $orders = $this->getLatestOrders(2);
        $expectedOrders = [
            [
                'product_id' => 2,
                'price' => 850,
            ],
            [
                'product_id' => 1,
                'price' => 800,
            ],
        ];
        foreach ($expectedOrders as $i => $expected) {
            $order = $orders[$i];
            foreach ($expected as $field => $expectedValue) {
                $this->assertSame($expectedValue, $order[$field]);
            }
        }
    }

    #[Test]
    public function 注文時に、支払い方法を指定できる(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $order = new BentoOrder(1, 'bento', 1, [], 800, $db, false, false, false, null, 'e_money');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $orders = $this->getLatestOrders(2);
        $expectedOrders = [
            [
                'payment_method' => 'e_money',
            ],
        ];
        foreach ($expectedOrders as $i => $expected) {
            $order = $orders[$i];
            foreach ($expected as $field => $expectedValue) {
                $this->assertSame($expectedValue, $order[$field]);
            }
        }
    }

    #[Test]
    public function 単体の弁当を注文して、在庫を超過していると拒否する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1000, $customizationIds, 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        $orderManager->finalizeOrders();
        $this->expectOutputString(
            '申し訳ありません、在庫が不足しています。' . \PHP_EOL
        );
        $this->assertEmpty($this->getLatestOrders(1));
    }

    #[Test]
    public function 単体の弁当をカスタマイズして注文して、正常に処理が完了する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [1, 3];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'customizations' => '[1,3]',
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 単体の弁当をカスタマイズして注文して、料金が上乗せされる(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager();
        $order = new BentoOrder(1, 'bento', 1, [1, 3], 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();
        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 950,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 組み合わせできないカスタマイズは無視する(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager();
        $order = new BentoOrder(9, 'bento', 1, [1, 4], 650, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 730,
            'customizations' => '[4]',
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 割引になるカスタマイズをして注文して、正常に処理が完了する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [6];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 700,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 特大唐揚げ弁当とご飯大盛りはお得(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = BentoDB::BENTO_KARAAGE_TOKUDAI_ID;
        $customizationIds = [BentoDB::CUSTOMIZE_GOHAN_OOMORI_ID];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 900, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 900,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function お得意様からの注文については5％割引する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [1, 3];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, true, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 903,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 弁当とお茶を一緒に買うと50円引き(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [BentoDB::CUSTOMIZE_OCHA_ID];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 880,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 弁当以外とお茶を一緒に買っても50円引きしない(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 6;
        $customizationIds = [BentoDB::CUSTOMIZE_OCHA_ID];

        $order = new BentoOrder($productId, 'sozai', 1, $customizationIds, 200, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 330,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 単体の弁当を5個以上の購入で300円値引きする(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;

        $order = new BentoOrder($productId, 'bento', 5, [], 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 3700,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function タイムセール中は120円値引き(): void
    {
        Chronos::setTestNow('2023-11-14 15:00');

        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 2;

        $order = new BentoOrder($productId, 'bento', 2, [], 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 1480,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function タイムセール中でも対象外の弁当は値引きしない(): void
    {
        Chronos::setTestNow('2023-11-14 15:00');

        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;

        $order = new BentoOrder($productId, 'bento', 2, [], 750, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 1500,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 予約時にはタイムセールの値引きを適用しない(): void
    {
        Chronos::setTestNow('2023-11-14 15:00');

        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 2;

        $order = new BentoOrder($productId, 'bento', 1, [], 850, $db, false, true, true, 15, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 850,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 割り箸が必要な注文をして、正常に処理が完了する(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 1;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        $orderManager->finalizeOrders();
        $this->expectOutputString(
            '注文が完了しました ID: 1、数量: 1(割り箸が必要)、合計金額: 800円、支払い方法: cash' . \PHP_EOL
        );
    }

    #[Test]
    public function 引換券を利用して弁当を注文して、正常に処理が完了する(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager();

        $order = new BentoOrder(1, 'bento', 1, [], 800, $db, false, false, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders(true);
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 0,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 引換券を利用して惣菜は0円にならない(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager(true);

        $order = new BentoOrder(6, 'souzai', 1, [], 200, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 200,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 引換券は最も高い弁当に適用される(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager();

        $order = new BentoOrder(1, 'bento', 1, [], 800, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);
        $order = new BentoOrder(9, 'bento', 1, [], 650, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders(true);
        ob_end_clean();

        $orders = $this->getLatestOrders(2);
        $orderPrices = array_combine(array_column($orders, 'product_id'), array_column($orders, 'price'));
        $expectedPrices = [
            1 => 0,
            9 => 650,
        ];
        foreach ($expectedPrices as $obentoId => $price) {
            $this->assertSame($orderPrices[$obentoId], $price);
        }
    }

    #[Test]
    public function 引換用は1個分だけ適用される(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager();

        $order = new BentoOrder(1, 'bento', 3, [4], 800, $db, false, true, false, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders(true);
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 1840,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 引換用を使おうとして対象がなかったら通知を出す(): void
    {
        $db = new BentoDB();

        $orderManager = new BentoOrderManager(true);

        $order = new BentoOrder(4, 'bento', 1, [], 900, $db, false, true, false, null, 'cash');
        $orderManager->addOrder($order);

        $orderManager->finalizeOrders(true);
        $this->expectOutputString(
            <<<'EOC'
                引換券を利用する条件を満たす注文がありません。
                注文が完了しました ID: 4、数量: 1、合計金額: 900円、支払い方法: cash

                EOC
        );

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'price' => 900,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 弁当を予約できる(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 8;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 4500, $db, false, true, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'is_pre_order' => 1,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 弁当の予約時に受け取り予定時間を指定できる(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 8;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 4500, $db, false, true, true, 17, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];
        $expected = [
            'pickup_time' => '17',
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 予約限定商品を予約できる(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 8;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 4500, $db, false, true, true, null, 'cash');
        $orderManager->addOrder($order);

        ob_start();
        $orderManager->finalizeOrders();
        ob_end_clean();

        $order = $this->getLatestOrders(1)[0];

        $expected = [
            'is_pre_order' => 1,
        ];
        foreach ($expected as $field => $expectedValue) {
            $this->assertSame($expectedValue, $order[$field]);
        }
    }

    #[Test]
    public function 予約限定商品を即時購入できない(): void
    {
        $db = new BentoDB();
        $orderManager = new BentoOrderManager();

        $productId = 8;
        $customizationIds = [];

        $order = new BentoOrder($productId, 'bento', 1, $customizationIds, 4500, $db, false, false, false, null, 'cash');
        $orderManager->addOrder($order);

        $orderManager->finalizeOrders();

        $this->expectOutputString(
            '申し訳ありません、在庫が不足しています。' . \PHP_EOL
        );
        $this->assertEmpty($this->getLatestOrders(1));
    }

    private function getLatestOrders(int $count): array
    {
        $dba = new \PDO('sqlite:' . DB_PATH);
        $stmt = $dba->prepare('SELECT * FROM orders ORDER BY id desc limit ?');
        $stmt->execute([$count]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
