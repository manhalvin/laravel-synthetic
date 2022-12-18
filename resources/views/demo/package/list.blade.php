<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Demo Package </title>
</head>

<body>
    <h1 class="text-center">Demo Package</h1>
    <div class='container'>
        <div class='row'>
            <div class="col-sm-12">
                @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                @endif
                <a class="btn btn-primary mt-2 mb-2" href="{{ route('demo.package.add') }}" role="button">Thêm</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td scope="col">ID</td>
                            <td scope="col">Title</td>
                            <td scope="col">Content</td>
                            <td scope="col">Image</td>
                            <td scope="col">Quản lý</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach ($posts as $item )
                        @php
                        $t++;
                        @endphp
                        <tr>
                            <td scope="row">{{ $t }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{!! $item->content !!}</td>
                            <td>
                                <img src="{{ url('/') }}/{{ $item->image }}" alt="" class="img-fluid w-auto h-25">
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm mt-2 mb-2" href="{{ route('demo.package.edit',$item->id ) }}" role="button">Sửa</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('demo.package.delete',$item->id ) }}" role="button">Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>
