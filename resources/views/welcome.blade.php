<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ارسال SMS</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="container pt-5">
        <h1>پنل ارسال SMS</h1>
        <hr>
        @include('includes.error')
        <section class="d-flex justinfy-content-between align-items-center">
            <div class="container mt-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create">
                    ارسال پیام
                </button>
            </div>
            <div>
                <form action="" method="GET">
                    <div class="input-group">
                        <input name="date" data-jdp class="form-control" value="{{ $date }}">
                        <button type="submit" class="btn btn-primary">فیلتر کن</button>
                    </div>
                </form>
            </div>

            <div class="modal fade" id="create">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">ارسال</h4>
                        </div>

                        <form action="{{ route('send') }}" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <input type="text" value="{{ old('API_key') }}" class="form-control mb-2"
                                    placeholder="API کلید" name="API_key">
                                <input type="text" value="{{ old('template') }}" class="form-control mb-2"
                                    placeholder="نام تمپلت" name="template">
                                <input type="text" value="{{ old('param') }}" class="form-control mb-2"
                                    placeholder="لینک" name="param">
                                <input type="file" name="list" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">ارسال</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-borderless border-0">
                <thead>
                    <tr class="table-success">
                        <th class="text-center">پیام</th>
                        <th class="text-center">عنوان پیام</th>
                        <th class="text-center">ردیف اکسل</th>
                        <th class="text-center">شماره تماس</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receptors as $receptor)
                        <tr>
                            <td class="text-center">
                                @if ($receptor->message_id)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#show{{$receptor->id}}">
                                        مشاهده
                                    </button>
                                    <div class="modal fade" id="show{{$receptor->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">پیام</h4>
                                                </div>

                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="text" value="{{ $receptor->message->API_key }}" class="form-control mb-2"
                                                            placeholder="API کلید" readonly>
                                                        <input type="text" value="{{ $receptor->message->template }}" class="form-control mb-2"
                                                            placeholder="نام تمپلت" readonly>
                                                        <input type="text" value="{{ $receptor->message->param }}" class="form-control mb-2"
                                                            placeholder="لینک" readonly>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($receptor->message_id)
                                    {{ $receptor->message->template }}
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($receptor->row)
                                    {{ $receptor->row }}
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($receptor->phone)
                                    {{ $receptor->phone }}
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($receptor->status == 0)
                                    <span class="badge bg-danger">ارسال نشد</span>
                                @else
                                    <span class="badge bg-success">ارسال شد</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($receptor->created_at)
                                    {{ $receptor->created_at }}
                                @else
                                    ندارد
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container my-5">
        <section class="d-block w-25" style="margin-right: auto">
            {{ $receptors->links() }}
        </section>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script>
        jalaliDatepicker.startWatch();
    </script>
</body>

</html>
