var classes = [
    {
        "name": "O0h\\Obento\\BentoOrderManager",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "addOrder",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "finalizeOrders",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "useVoucher",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getOrderToApplyVoucher",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 4,
        "nbMethods": 4,
        "nbMethodsPrivate": 2,
        "nbMethodsPublic": 2,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 10,
        "ccn": 7,
        "ccnMethodMax": 4,
        "externals": [],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 34,
        "vocabulary": 10,
        "volume": 112.95,
        "difficulty": 7.67,
        "effort": 865.92,
        "level": 0.13,
        "bugs": 0.04,
        "time": 48,
        "intelligentContent": 14.73,
        "number_operators": 11,
        "number_operands": 23,
        "number_operators_unique": 4,
        "number_operands_unique": 6,
        "cloc": 24,
        "loc": 65,
        "lloc": 41,
        "mi": 89.92,
        "mIwoC": 49.5,
        "commentWeight": 40.42,
        "kanDefect": 0.89,
        "relativeStructuralComplexity": 36,
        "relativeDataComplexity": 0.36,
        "relativeSystemComplexity": 36.36,
        "totalStructuralComplexity": 144,
        "totalDataComplexity": 1.43,
        "totalSystemComplexity": 145.43,
        "package": "O0h\\Obento\\",
        "pageRank": 0.17,
        "afferentCoupling": 0,
        "efferentCoupling": 0,
        "instability": 0,
        "violations": {}
    },
    {
        "name": "O0h\\Obento\\BentoOrder",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isOrderAcceptable",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "calculateTotalPrice",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "registerOrder",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getBasePrice",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isVoucherApplicable",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "applyVoucher",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isTimeSale",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 8,
        "nbMethods": 7,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 6,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 31,
        "ccn": 25,
        "ccnMethodMax": 11,
        "externals": [
            "O0h\\Obento\\BentoDB"
        ],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 241,
        "vocabulary": 64,
        "volume": 1446,
        "difficulty": 23.72,
        "effort": 34305.61,
        "level": 0.04,
        "bugs": 0.48,
        "time": 1906,
        "intelligentContent": 60.95,
        "number_operators": 86,
        "number_operands": 155,
        "number_operators_unique": 15,
        "number_operands_unique": 49,
        "cloc": 1,
        "loc": 113,
        "lloc": 112,
        "mi": 37.07,
        "mIwoC": 29.81,
        "commentWeight": 7.26,
        "kanDefect": 1.15,
        "relativeStructuralComplexity": 121,
        "relativeDataComplexity": 0.61,
        "relativeSystemComplexity": 121.61,
        "totalStructuralComplexity": 968,
        "totalDataComplexity": 4.92,
        "totalSystemComplexity": 972.92,
        "package": "O0h\\Obento\\",
        "pageRank": 0.17,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "violations": {}
    },
    {
        "name": "O0h\\Obento\\BentoDB",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getStock",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updateReservedStock",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "updateStockForPreOrder",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getCustomizationPrice",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isValidCustomization",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getProductType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isReservationOnly",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "addOrder",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getProductInfo",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 10,
        "nbMethods": 10,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 10,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 14,
        "ccn": 5,
        "ccnMethodMax": 2,
        "externals": [
            "PDO"
        ],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 125,
        "vocabulary": 41,
        "volume": 669.69,
        "difficulty": 8.74,
        "effort": 5855.04,
        "level": 0.11,
        "bugs": 0.22,
        "time": 325,
        "intelligentContent": 76.6,
        "number_operators": 23,
        "number_operands": 102,
        "number_operators_unique": 6,
        "number_operands_unique": 35,
        "cloc": 0,
        "loc": 72,
        "lloc": 72,
        "mi": 39.02,
        "mIwoC": 39.02,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 16,
        "relativeDataComplexity": 1.56,
        "relativeSystemComplexity": 17.56,
        "totalStructuralComplexity": 160,
        "totalDataComplexity": 15.6,
        "totalSystemComplexity": 175.6,
        "package": "O0h\\Obento\\",
        "pageRank": 0.66,
        "afferentCoupling": 1,
        "efferentCoupling": 1,
        "instability": 0.5,
        "violations": {}
    }
]