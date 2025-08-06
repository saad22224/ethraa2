<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTCN Form</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .title {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
            font-size: 18px;
            font-weight: 500;
            line-height: 1.6;
        }

        .input-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .input-group {
            display: flex;
            gap: 8px;
        }

        .digit-input {
            width: 45px;
            height: 45px;
            border: 2px solid #ddd;
            border-radius: 6px;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            color: #333;
            background: #fff;
            transition: all 0.3s ease;
        }

        .digit-input:focus {
            outline: none;
            border-color: #6b7ce6;
            box-shadow: 0 0 0 3px rgba(107, 124, 230, 0.1);
        }

        .digit-input:hover {
            border-color: #999;
        }

        .separator {
            display: flex;
            align-items: center;
            color: #999;
            font-size: 20px;
            font-weight: bold;
            margin: 0 8px;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #6b7ce6, #8b9ef5);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #5a6bd8, #7a8eec);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(107, 124, 230, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-message {
            text-align: center;
            color: #6b7ce6;
            font-size: 16px;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }

            .title {
                font-size: 16px;
                margin-bottom: 30px;
            }

            .digit-input {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .separator {
                font-size: 18px;
                margin: 0 6px;
            }

            .submit-btn {
                padding: 14px;
                font-size: 16px;
            }

            .input-container {
                gap: 6px;
            }

            .input-group {
                gap: 6px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 15px;
            }

            .digit-input {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .separator {
                font-size: 16px;
                margin: 0 4px;
            }

            .input-container {
                gap: 4px;
            }

            .input-group {
                gap: 4px;
            }

            .title {
                font-size: 14px;
            }
        }

        @media (max-width: 380px) {
            .input-container {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .separator {
                display: none;
            }

            .input-group {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            (MTCN) الرجاء إدخال رقم التتبع المكون من 10 أرقام
        </div>
        @if (session('error'))
            <p style="color: red ; text-align: center ; margin-bottom: 20px">رقم الحواله خاطئ</p>
        @endif

        <form id="mtcnForm" method="POST" action="">
            @csrf
            <div class="input-container">
                <div class="input-group">
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                </div>

                <div class="separator">-</div>

                <div class="input-group">
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                </div>

                <div class="separator">-</div>

                <div class="input-group">
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                    <input type="text" class="digit-input" maxlength="1" />
                </div>
            </div>

            <button type="submit" class="submit-btn">يكمل</button>

            {{-- <div class="error-message">
                لا تعرف رقم MTCN؟
            </div> --}}
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.digit-input');
            const form = document.getElementById('mtcnForm');

            // Auto-focus next input when typing
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Move to next input if current is filled
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = pastedData.replace(/[^0-9]/g, '');

                    for (let i = 0; i < numbers.length && (index + i) < inputs.length; i++) {
                        inputs[index + i].value = numbers[i];
                    }

                    // Focus the next empty input or the last filled one
                    const nextEmptyIndex = Math.min(index + numbers.length, inputs.length - 1);
                    inputs[nextEmptyIndex].focus();
                });
            });

            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const mtcnValue = Array.from(inputs).map(input => input.value).join('');

                if (mtcnValue.length === 10) {
                    // alert(`رقم MTCN المدخل: ${mtcnValue}`);
                    form.action = `/tracking/${mtcnValue}`;
                    form.submit(); // ⬅️ دي المهمة

                } else {
                    alert('يرجى إدخال رقم MTCN كاملاً (10 أرقام)');
                }
            });

            // Focus first input on page load
            inputs[0].focus();
        });
    </script>
</body>

</html>
