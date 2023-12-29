var classes = [
    {
        "name": "O0h\\Obento\\BentoOrderManager",
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
                "name": "addOrder",
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
                "name": "finalizeOrders",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 4,
        "nbMethods": 4,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 4,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 12,
        "ccn": 9,
        "ccnMethodMax": 8,
        "externals": [],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 48,
        "vocabulary": 13,
        "volume": 177.62,
        "difficulty": 9.69,
        "effort": 1720.7,
        "level": 0.1,
        "bugs": 0.06,
        "time": 96,
        "intelligentContent": 18.34,
        "number_operators": 17,
        "number_operands": 31,
        "number_operators_unique": 5,
        "number_operands_unique": 8,
        "cloc": 0,
        "loc": 44,
        "lloc": 44,
        "mi": 47.19,
        "mIwoC": 47.19,
        "commentWeight": 0,
        "kanDefect": 0.89,
        "relativeStructuralComplexity": 16,
        "relativeDataComplexity": 0.3,
        "relativeSystemComplexity": 16.3,
        "totalStructuralComplexity": 64,
        "totalDataComplexity": 1.2,
        "totalSystemComplexity": 65.2,
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