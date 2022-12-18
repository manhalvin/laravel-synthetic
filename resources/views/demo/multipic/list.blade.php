<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title> Demo Mulitpic List </title>
</head>

<body>
    <h1 class="text-center">Demo Mulitpic List</h1>
    <div id="content" class="container">
        <a class="btn btn-primary mt-2 mb-2" href="{{ route('demo.multi.add') }}" role="button">Thêm</a>
        <a class="btn btn-primary mt-2 mb-2" href="{{ route('demo.multi.deleteAll') }}" role="button">Xóa tất cả</a>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách hình ảnh</h5>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('demo.multi.action') }}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name='act'>
                            <option value="">Chọn</option>
                            <option value="delete_all">Xóa tất cả</option>
                            <option value="editv2">Sửa</option>
                            <option value="deletev2">Xóa</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary mt-2 mb-2">
                    </div>
                    <table class="table table-bordered table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <td scope="col">ID</td>
                                <td scope="col">Image</td>
                                <td scope="col">Quản lý</td>
                                <td scope="col">Update Image</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($muliti as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name='list_check[]' value="{{ $item->id }}">
                                    </td>
                                    <td scope="row">{{ $t }}</td>
                                    <td>
                                        <img src="{{ url('/') }}/{{ $item->image }}" alt=""
                                            class="img-fluid w-auto h-25">
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm mt-2 mb-2"
                                            href="{{ route('demo.multi.edit', $item->id) }}" role="button">Sửa</a>
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('demo.multi.delete', $item->id) }}" role="button">Xóa</a>

                                    </td>
                                    <td>
                                        <input type="file" id="avatar" name="image[{{$item->id}}]"  class="mb-2 mt-2">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $("input[name='checkall']").click(function() {
                var checked = $(this).is(':checked');
                $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
            });
        });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



</body>

</html>
