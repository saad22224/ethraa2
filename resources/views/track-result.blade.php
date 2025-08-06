<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تتبع التحويل</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            direction: rtl;
        }

        /* Status Bar */
        .status-bar {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 8px 15px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-left {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-right {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .signal-bars {
            display: flex;
            gap: 2px;
            align-items: flex-end;
        }

        .bar {
            width: 3px;
            background: white;
            border-radius: 1px;
        }

        .bar:nth-child(1) { height: 4px; }
        .bar:nth-child(2) { height: 6px; }
        .bar:nth-child(3) { height: 8px; }
        .bar:nth-child(4) { height: 10px; }

        .battery {
            width: 20px;
            height: 10px;
            border: 1px solid white;
            border-radius: 2px;
            position: relative;
        }

        .battery::after {
            content: '';
            position: absolute;
            right: -3px;
            top: 3px;
            width: 2px;
            height: 4px;
            background: white;
            border-radius: 0 1px 1px 0;
        }

        .battery-fill {
            background: white;
            height: 100%;
            width: 74%;
            border-radius: 1px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 500;
            color: #f1c40f;
        }

        .menu-btn {
            background: transparent;
            border: 2px solid #3498db;
            color: #3498db;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .menu-btn:hover {
            background: #3498db;
            color: white;
        }

        /* Content */
        .content {
            background: white;
            padding: 30px 20px;
        }

        .tracking-info {
            text-align: center;
            margin-bottom: 40px;
        }

        .tracking-label {
            color: #95a5a6;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .tracking-number {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        /* Progress Steps */
        .progress-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px 0;
        }

        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 14px;
            top: 35px;
            width: 2px;
            height: 40px;
            background: #e0e0e0;
        }

        .step.completed::after {
            background: #27ae60;
        }

        .step-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: bold;
        }

        .step.completed .step-icon {
            background: #27ae60;
            color: white;
        }

        .step.current .step-icon {
            background: #27ae60;
            color: white;
            border: 3px solid #2ecc71;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.2);
        }

        .step.pending .step-icon {
            background: #ecf0f1;
            color: #95a5a6;
            border: 2px solid #e0e0e0;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .step.completed .step-title,
        .step.current .step-title {
            color: #27ae60;
        }

        .step.pending .step-title {
            color: #95a5a6;
        }

        .step-description {
            font-size: 14px;
            color: #7f8c8d;
            line-height: 1.5;
        }

        .step.current .step-description {
            color: #2c3e50;
        }

        /* Bottom Button */
        .bottom-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .track-another-btn {
            width: 100%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .track-another-btn:hover {
            background: linear-gradient(135deg, #2980b9, #21618c);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .content {
                padding: 20px 15px;
            }

            .tracking-number {
                font-size: 20px;
            }

            .step-title {
                font-size: 16px;
            }

            .bottom-section {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Status Bar -->
    {{-- <div class="status-bar">
        <div class="status-left">
            <span>البحث</span>
            <div class="signal-bars">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <span>3G</span>
        </div>
        <div class="status-center">22:50</div>
        <div class="status-right">
            <span>74%</span>
            <div class="battery">
                <div class="battery-fill"></div>
            </div>
            <span>📍</span>
        </div>
    </div> --}}

    <!-- Header -->
    <div class="header">
        <h1>تتبع التحويل</h1>
        {{-- <button class="menu-btn">القائمة</button> --}}
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Tracking Info -->
        <div class="tracking-info">
            <div class="tracking-label">رقم التتبع (MTCN):</div>
            <div class="tracking-number">{{$transaction->transaction_code}}</div>
        </div>

        <!-- Progress Steps -->
        <div class="progress-container">
            <div class="step completed">
                <div class="step-icon">✓</div>
                <div class="step-content">
                    <div class="step-title">تم الإرسال</div>
                </div>
            </div>

            <div class="step completed">
                <div class="step-icon">✓</div>
                <div class="step-content">
                    <div class="step-title">قيد المعالجة</div>
                </div>
            </div>

            <div class="step current">
                <div class="step-icon">●</div>
                <div class="step-content">
                    <div class="step-title">متاح للاستلام</div>
                    <div class="step-description">
                        التحويل المالي جاهز للاستلام. يجب على المستلم إحضار رقم التتبع (MTCN) وهوية شخصية صادرة من الحكومة لاستلام الأموال.
                    </div>
                </div>
            </div>

            <div class="step pending" >
                <div class="step-icon" style="{{ $transaction->status == '1' ? 'background-color: #27ae60;' : '' }}">○</div>
                <div class="step-content">
                    <div class="step-title" style="{{ $transaction->status == '1' ? 'color: #27ae60;' : '' }}">تم الاستلام</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Button -->
    <div class="bottom-section">
        <button class="track-another-btn" onclick="trackAnother()">تتبع تحويل آخر</button>
    </div>

    <script>
        function trackAnother() {
            // alert('سيتم الانتقال لصفحة تتبع تحويل جديد');
            // يمكن إضافة كود الانتقال هنا
            window.location.href = '/tracking';
        }

        // Add some interactivity
        document.querySelectorAll('.step').forEach(step => {
            step.addEventListener('click', function() {
                if (!this.classList.contains('pending')) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                }
            });
        });
    </script>
</body>
</html>