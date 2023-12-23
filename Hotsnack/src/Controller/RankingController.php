<?php

declare(strict_types=1);

namespace O0h\IyaaaaaNaCodeExample\Controller;

use O0h\IyaaaaaNaCodeExample\Model\HotsnackVote;

class RankingController extends Controller
{
    public function index(): void
    {
        $hotsnackVote = new HotsnackVote();
        $ranking = $hotsnackVote->getRanking();
        $this->set(['ranking' => $ranking->fetchAll(\PDO::FETCH_ASSOC)]);

        $this->render('ranking/index.php');
    }
}
