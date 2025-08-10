<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>رسالة ترحيبية</title> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            background-color: #1a1a1a;
            color: #d4af37;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        .message {
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 4px solid #d4af37;
            margin: 20px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .divider {
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }

        p {
            margin: 15px 0;
        }

        .highlight {
            background-color: #faf6e8;
            padding: 10px;
            border-right: 3px solid #d4af37;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>مرحباً بك في موقعنا</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">مرحباً بك، {{ $name }}</div>

            <p>نود أن نرحب بك في عائلتنا الكبيرة!</p>

            <div class="message">
                {{ $response }}
            </div>

            <p>للحصول على المساعدة، يمكنك التواصل معنا:</p>

            <div class="highlight">
                البريد الإلكتروني: support@example.com
                <br>
                الهاتف: +20-123-456-789
            </div>

            <p>شكراً لثقتك بنا، ونتمنى لك تجربة رائعة.</p>

            <p>
                مع أطيب التحيات،<br>
                <strong>فريق العمل</strong>
            </p>
        </div>
    </div>
</body>

</html>
