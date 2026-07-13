<?php

namespace App\Services;

use App\Models\Order;
use PHPMailer\PHPMailer\Exception as MailException;
use PHPMailer\PHPMailer\PHPMailer;
use Throwable;

class OrderMailer
{
    public function sendCustomerConfirmation(Order $order): bool
    {
        if (! filter_var($order->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $mail = $this->mailer();
        $fromAddress = env('ORDER_MAIL_FROM_ADDRESS', env('ORDER_MAIL_USERNAME'));
        $fromName = env('ORDER_MAIL_FROM_NAME', 'Asif Raza Perfumes');

        try {
            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($order->email, $order->customer_name);

            if ($admin = env('ORDER_MAIL_ADMIN_ADDRESS')) {
                $mail->addReplyTo($admin, $fromName);
            }

            $mail->Subject = 'Your Asif Raza Perfumes order ' . $order->order_number;
            $mail->isHTML(true);
            $mail->Body = $this->htmlBody($order);
            $mail->AltBody = $this->textBody($order);

            return $mail->send();
        } catch (MailException|Throwable $exception) {
            report($exception);

            return false;
        }
    }

    private function mailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = env('ORDER_MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth = true;
        $mail->Username = env('ORDER_MAIL_USERNAME');
        $mail->Password = env('ORDER_MAIL_PASSWORD');
        $mail->SMTPSecure = env('ORDER_MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
        $mail->Port = (int) env('ORDER_MAIL_PORT', 587);
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        return $mail;
    }

    private function htmlBody(Order $order): string
    {
        $items = $order->items->map(function ($item) {
            return '<tr><td style="padding:10px;border-bottom:1px solid #eee;">'
                . e($item->product_name) . ' x ' . (int) $item->quantity
                . '</td><td style="padding:10px;border-bottom:1px solid #eee;text-align:right;">$'
                . number_format((float) $item->subtotal, 0) . '</td></tr>';
        })->implode('');

        return '<div style="font-family:Arial,sans-serif;color:#211b18;line-height:1.6">'
            . '<h1 style="margin:0 0 12px;">Order received</h1>'
            . '<p>Hi ' . e($order->customer_name) . ', thank you for your order.</p>'
            . '<p><strong>Tracking / Order No:</strong> ' . e($order->order_number) . '</p>'
            . '<p><strong>Status:</strong> ' . e($order->statusLabel()) . '</p>'
            . '<table style="width:100%;border-collapse:collapse;margin:18px 0;">' . $items . '</table>'
            . '<p><strong>Total:</strong> $' . number_format((float) $order->total, 0) . '</p>'
            . '<p><strong>Delivery address:</strong><br>' . nl2br(e($order->address)) . '</p>'
            . '<p>Our team will contact you soon for confirmation.</p>'
            . '</div>';
    }

    private function textBody(Order $order): string
    {
        $items = $order->items->map(fn ($item) => $item->product_name . ' x ' . $item->quantity . ' - $' . number_format((float) $item->subtotal, 0))->implode(PHP_EOL);

        return "Order received\n"
            . "Tracking / Order No: {$order->order_number}\n"
            . "Customer: {$order->customer_name}\n"
            . "Status: {$order->statusLabel()}\n\n"
            . $items . "\n\n"
            . 'Total: $' . number_format((float) $order->total, 0) . "\n"
            . "Delivery address: {$order->address}\n";
    }
}
