<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الإدارية</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- الشريط الجانبي -->
    @include('sidebar')

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <!-- الهيدر العلوي -->
        @include('header')



        <div class="page-content" id="transfers">
            <div class="page-header">
                <h2>التحويلات المصرفية</h2>
                <button class="btn btn-primary" onclick="showAddTransferModal()">
                    <i class="fas fa-plus"></i>
                    إضافة تحويل
                </button>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="البحث في التحويلات..." id="transferSearch">
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>رقم الحوالة</th>
                            <th>كود الحوالة</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>العنوان</th>
                            <th>الكمية</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="transfersTableBody">
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_number }}</td>
                                <td>{{ $transaction->transaction_code }}</td>
                                <td> {{ $transaction->user->name }}</td>
                                <td>{{ $transaction->user->email }}</td>
                                <td>{{ $transaction->addresse }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td><span
                                        class="status
                                 {{ $transaction->status == 1 ? 'completed' : 'pending' }}">{{ $transaction->status == 1 ? 'مكتملة' : 'قيد المعالجة' }}</span>
                                </td>
                                @if($transaction->status !== 1)
                                <td>
                                    <form action="{{ route('transactions.status', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            style="background-color: #28a745; color: white; padding: 6px 12px; font-size: 14px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.2s ease;"
                                            onmouseover="this.style.backgroundColor='#218838'"
                                            onmouseout="this.style.backgroundColor='#28a745'"
                                            onclick="return confirm('تأكيد تغيير حالة المعاملة؟')">
                                            مكتمل
                                        </button>
                                    </form>
                                </td>
                                @endif
                                @if($transaction->status == 1)
                                <td>
                                    <form action="{{ route('transactions.delete', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action delete"
                                            onclick=" return confirm('هل تريد حذف هذا المكتب؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td>TR002</td>
                            <td>MTR789012</td>
                            <td>فاطمة علي</td>
                            <td>fatima@example.com</td>
                            <td>الرياض، السعودية</td>
                            <td>$1,200</td>
                            <td>2024-01-19</td>
                            <td><span class="status pending">قيد المعالجة</span></td>
                        </tr>
                        <tr>
                            <td>TR003</td>
                            <td>MTR345678</td>
                            <td>خالد أحمد</td>
                            <td>khaled@example.com</td>
                            <td>دبي، الإمارات</td>
                            <td>$800</td>
                            <td>2024-01-18</td>
                            <td><span class="status completed">مكتملة</span></td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>




















    </main>


    <script src="{{ asset('script.js') }}"></script>


</body>

</html>
