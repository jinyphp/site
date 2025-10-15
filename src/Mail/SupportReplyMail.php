<?php

namespace Jiny\Site\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 답변 이메일
 */
class SupportReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $support;
    public $adminReply;

    /**
     * Create a new message instance.
     */
    public function __construct(SiteSupport $support, $adminReply = null)
    {
        $this->support = $support;
        $this->adminReply = $adminReply ?? $support->admin_reply;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = '지원 요청 답변: ' . $this->support->subject;

        return $this->subject($subject)
                    ->view('jiny-site::emails.support.reply')
                    ->with([
                        'support' => $this->support,
                        'adminReply' => $this->adminReply,
                        'customerName' => $this->support->user ? $this->support->user->name : ($this->support->name ?? '고객님'),
                    ]);
    }
}