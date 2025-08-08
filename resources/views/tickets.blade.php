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



        <!-- صفحة مكاتب التحويل -->
        <div class="page-content" id="offices">
            <div class="page-header">
                <h2> الشكاوي</h2>

            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="البحث في المكاتب..." id="officeSearch">
            </div>

            <div class="offices-grid" id="officesGrid">
                @foreach ($tickets as $ticket)
                    <div class="office-card">
                        <div class="office-header">
                            <h3>{{ $ticket->user->name }}</h3>
                            <span class="office-country">
                                <a href="mailto:{{ $ticket->user->email }}">
                                    {{ $ticket->user->email }}
                                </a>
                            </span>
                        </div>
                        <div class="office-details">
                            <p
                                style="
                                    word-break: break-word; 
    white-space: pre-wrap;">
                                <i class="fas fa-map-marker-alt">
                                </i>{{ $ticket->message }}
                            </p>
                            @if ($ticket->user->phone)
                                <p dir="ltr"><i
                                        class="fas fa-phone"></i>{{ $ticket->user->country_code }}{{ $ticket->user->phone }}
                                </p>
                            @endif
                        </div>
                        <div class="office-actions">
                            <button class="btn-action edit" onclick='showresponsemodel(@json($ticket))'>
                                <i class="fas fa-envelope"></i>
                            </button>
                            <form action="{{ route('tickets.delete', $ticket->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action delete" onclick=" return confirm('هل تريد حذف هذا الشكوي')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>



        <div class="modal" id="responsemodel">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h3>إضافة مكتب جديد</h3> --}}
                    <button class="modal-close" onclick="closeresponse()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="officeForm" method="POST" action="{{ route('tickets.response') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $ticket->user->email ?? null }}">
                        <div class="form-group">
                            <label>الرد</label>
                            <textarea name="response" class="form-control" required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="closeresponse()">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة االرد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            function showresponsemodel(ticket) {
                document.getElementById('responsemodel').style.display = 'block';
                document.getElementById('responsemodel').style.textAlign = 'center';
            }

            function closeresponse() {
                document.getElementById('responsemodel').style.display = 'none';
            }
        </script>

    </main>


    <script src="{{ asset('script.js') }}"></script>


</body>

</html>
