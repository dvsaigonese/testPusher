@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    <ul id="users">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        //hàm gọi api lấy data để render lên ui
        const getUsers = () => {
            window.axios.get("/api/users")
            .then((response) => {
                const usersElement = document.getElementById('users');

                let users = response.data;

                users.forEach(user => {
                    let element = document.createElement('li');

                    element.setAttribute('id', user.id);
                    element.innerText = user.name;

                    usersElement.appendChild(element);
                });
            });
        }
        getUsers();
    </script>
    <script>
        
    </script>
@endpush