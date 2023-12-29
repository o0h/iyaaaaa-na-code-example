INSERT INTO bento_products (name, price, stock, reserved_stock, sale_flag, product_type, reservation_only) VALUES
                                                                                                               ('焼き鯖弁当', 800, 100, 0, 0, 'bento', 0),
                                                                                                               ('チキンカツ弁当', 850, 100, 0, 1, 'bento', 0),
                                                                                                               ('野菜カレー弁当', 750, 100, 0, 0, 'bento', 1),
                                                                                                               ('特大唐揚げ弁当', 900, 50, 0, 0, 'bento', 0),
                                                                                                               ('鮭の塩焼き弁当', 950, 50, 0, 1, 'bento', 0),
                                                                                                               ('ライスコロッケ', 200, 230, 0, 0, 'souzai', 0),
                                                                                                               ('一口餃子', 80, 700, 0, 0, 'souzai', 0),
                                                                                                               ('お子様パーティー(オードブル)', 4500, 5, 0, 0, 'bento', 1),
                                                                                                               ('塩焼きそば弁当', 650, 170, 0, 0, 'bento', 0);
INSERT INTO bento_customizations (name, additional_price) VALUES
                                                              ('ご飯大盛り', 100),
                                                              ('追加のご飯', 50),
                                                              ('辛いソース', 50),
                                                              ('追加の野菜', 80),
                                                              ('チーズトッピング', 100),
                                                              ('ご飯を玄米に変更', -100),
                                                              ('お茶', 130);
INSERT INTO bento_customization_relations (bento_id, customization_id) VALUES
                                                                           (1, 1), -- 焼き鯖弁当にご飯大盛り
                                                                           (1, 3), -- 焼き鯖弁当に辛いソース
                                                                           (1, 4), -- 焼き鯖弁当に追加の野菜
                                                                           (1, 6), -- ご飯を玄米に変更
                                                                           (2, 2), -- チキンカツ弁当に追加のご飯
                                                                           (2, 4), -- チキンカツ弁当に追加の野菜
                                                                           (3, 1), -- 野菜カレー弁当にご飯大盛り
                                                                           (4, 5), -- 豚の生姜焼き弁当にチーズトッピング
                                                                           (1, 7), -- 焼き鯖弁当にお茶
                                                                           (2, 7), -- チキンカツ弁当にお茶
                                                                           (3, 7), -- 野菜カレー弁当にお茶
                                                                           (5, 7), -- 豚の生姜焼き弁当にお茶
                                                                           (6, 7), -- ライスコロッケにお茶
                                                                           (9, 4); -- 塩焼きそば弁当に追加の野菜
