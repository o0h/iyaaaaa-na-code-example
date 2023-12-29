-- お弁当テーブル
CREATE TABLE bento_products (
                                id INTEGER PRIMARY KEY AUTOINCREMENT,
                                name TEXT NOT NULL,
                                price INTEGER NOT NULL,
                                stock INTEGER NOT NULL,
                                reserved_stock INTEGER NOT NULL DEFAULT 0,
                                sale_flag INTEGER NOT NULL DEFAULT 0, -- 0: セール対象外, 1: セール対象
                                product_type TEXT DEFAULT 'bento', -- 'bento' または 'side_dish'
                                reservation_only INTEGER DEFAULT 0 -- 0: 通常商品, 1: 予約限定商品
);

-- カスタマイズオプションテーブル
CREATE TABLE bento_customizations (
                                      id INTEGER PRIMARY KEY AUTOINCREMENT,
                                      name TEXT NOT NULL,
                                      additional_price INTEGER NOT NULL
);

-- お弁当とカスタマイズオプションの関連テーブル
CREATE TABLE bento_customization_relations (
                                               bento_id INTEGER NOT NULL,
                                               customization_id INTEGER NOT NULL,
                                               PRIMARY KEY (bento_id, customization_id),
                                               FOREIGN KEY (bento_id) REFERENCES bento_products(id),
                                               FOREIGN KEY (customization_id) REFERENCES bento_customizations(id)
);

CREATE TABLE orders (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        product_id INTEGER NOT NULL,
                        quantity INTEGER NOT NULL,
                        customizations TEXT,  -- JSON形式やカンマ区切りのリストなど
                        price INTEGER NOT NULL,
                        payment_method TEXT,  -- 'cash', 'credit_card', 'e_money'
                        pickup_time TEXT,     -- 'HH:00' 形式
                        order_date DATE,
                        is_pre_order INTEGER DEFAULT 0, -- 0: 通常注文, 1: 予約注文
                        FOREIGN KEY (product_id) REFERENCES bento_products(id)
);
