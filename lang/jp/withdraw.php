<?php

return [
    "invalid_status" => "無効な出金ステータス。",
    "empty_bank_details" => "銀行の詳細を追加する必要があります。",
    "success_requested" => "新規引き出しのリクエストに成功しました。",
    "status" => [
        "pending" => "申請中",
        "accepted" => "加工済み",
        "rejected" => "不採用",
    ],
    "admin" => [
        "index" => [
            "title" => "要請の撤回",
            "user_name" => "ユーザー名",
            "amount" => "出金額",
            "status" => "退会ステータス",
            "created_at" => "作成日時",
            "actions" => "行動",
            "details" => "詳細を表示",
        ],
        "details" => [
            "title" => "出金詳細",
            "system_id" => "システムID：",
            "status" => "脱退する：",
            "amount" => "引き出し額",
        ],
        "bank" => [
            "title" => "銀行の詳細を引き出す",
            "account_name" => "口座名",
            "account_number" => "口座番号",
            "bank_name" => "銀行名",
            "ifsc" => "IFSCコード"
        ]
    ]
];
