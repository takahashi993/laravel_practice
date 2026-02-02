<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    // プロパティを追加
    public $userName;
    public $taskList;

    /**
     * @param string $userName 担当者名
     * @param string $taskList タスク一覧のテキスト
     */
    public function __construct($userName, $taskList)
    {
        $this->userName = $userName;
        $this->taskList = $taskList;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope//メールの送信設定（アドレスなど）
    {
        return new Envelope(
            subject: '【{サイト名}】翌日対応期限のタスクがあります', // メールの件名
            // from: new Address('another@example.com', '別名') // 送信元を上書きしたい場合
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content//メールの本文
    {
        return new Content(
            view: 'emails.welcome', // 使用するビューファイル（後述）
            with: [
                'name' => $this->userName, // ビューに渡すデータ
                'taskList' => $this->taskList, // タスク一覧
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // 例: public/docs/sample.pdf を添付
            // Attachment::fromPath(public_path('docs/sample.pdf'))
            //           ->as('sample.pdf')
            //           ->withMime('application/pdf'),
        ];
    }
}