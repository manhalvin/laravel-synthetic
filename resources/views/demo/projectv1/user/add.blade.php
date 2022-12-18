@extends('layouts.admin')
@section('content')
    <style>
        div.bootstrap-tagsinput {
            width: 100%;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: black !important;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div id="content" class="container-fluid">
        {{-- <div class="alert alert-success">
            Lượt truy cập: {{ $visit }}
        </div> --}}
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm thành viên
            </div>
            <div class="card-body">
                <form action='{{ route('projectv1.user.store') }}' method='POST'>
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>@lang('Ảnh:')</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror mb-2" name="avatar"
                            value='{{ old('avatar') }}' id='avatar' onchange="return checkAndFilterAvatar()">
                        <div id='avatarPreview'></div>

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}">
                        @error('email')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" data-role="tagsinput" name='role[]' />
                    </div>
                    <div class="form-group">

                        <b><label>@lang('Địa chỉ thường trú:')</label></b> <br>
                        <div class="form-group" role="textbox">
                            <div class="row">
                                <div class='col-4'>
                                    <label>Tỉnh/thành phố </label> <label class="red">(*)</label>
                                    <div class="controls">
                                        <select name="province"
                                            class="form-control  @error('province') is-invalid @enderror" id='province'
                                            required>
                                            <option value="">Chọn tỉnh/thành phố
                                            </option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('province')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <label>Quận/huyện</label> <label class="red">(*)</label>
                                    <div class="controls">
                                        <select name="district" id='district'
                                            class="form-control  @error('district') is-invalid @enderror" required>
                                            <option value=""> chọn quận/huyện </option>
                                        </select>
                                        @error('district')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <label>Phường/xã </label> <label class="red">(*)</label>
                                    <div class="controls">
                                        <select name="ward" class="form-control @error('ward') is-invalid @enderror"
                                            id='ward' required>
                                            <option value="">Chọn phường/xã </option>
                                        </select>
                                        @error('ward')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <label>@lang('Quốc tịch')</label>
                        <input type="text" name="country" list='coutries' class="form-control" placeholder="Nhập quốc tịch">
                        <datalist id='coutries'>
                            @foreach ($country as $v)
                                <option value="{{ $v->name }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Vai trò</label>
                        <select class="form-control" id="role_id" name='role_id'>
                            <option value="">Chọn vai trò</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                            {{-- <option value="2" @if (old('role_id') == 2) selected @endif>User</option> --}}
                        </select>
                        @error('role_id')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" name='btn-add' value="Thêm mới">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#province').on('change', function() {
                var idCountry = this.value;
                $("#district").html('');
                $.ajax({
                    url: "{{ url('projectv1/admin/user/districts/ajax') }}/" + idCountry,
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#district').html('<option value="">Chọn quận/huyện</option>');
                        $.each(result, function(key, value) {
                            $("#district").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#ward').html('<option value="">Chọn phường/xã</option>');
                    }
                });
            });
            $('#district').on('change', function() {
                var idState = this.value;
                $("#ward").html('');
                $.ajax({
                    url: "{{ url('projectv1/admin/user/wards/ajax') }}/" + idState,
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(res) {
                        $('#ward').html('<option value="">Chọn phường/xã </option>');
                        $.each(res, function(key, value) {

                            $("#ward").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function checkAndFilterAvatar() {
            var userFileImg = document.getElementById('avatar');
            var destOrignalFile = userFileImg.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(destOrignalFile)) {
                toastr.error('Bạn vui lòng tải lên tệp có phần mở rộng: .jpeg/.jpg/.png/.gif', {
                    timeOut: 5000
                })
                userFileImg.value = '';
                return false;
            } else {
                //Image displaying
                if (userFileImg.files && userFileImg.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatarPreview').innerHTML = '<img class="w-25 h-25" src="' + e.target
                            .result + '"/>';
                    };
                    reader.readAsDataURL(userFileImg.files[0]);
                }
            }
        }
    </script>
@endsection
