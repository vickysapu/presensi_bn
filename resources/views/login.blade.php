@include('layout.header')

<div id="layoutAuthentication_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                    <div class="card card-raised shadow-10 mt-5 mb-4">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                @php
                                $logo = App\Models\sekolah::all();
                                @endphp
                                @if ($logo->isNotEmpty())
                                @foreach ($logo as $logo)
                                <img class="mb-3" src="{{ asset('logo/' . $logo->logo_sekolah) }}" alt="Logo" style="height: 48px">
                                @endforeach
                                @endif
                                <h1 class="display-5 mb-0">Login</h1>
                            </div>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $item)
                                <p>{{ $item }}</p>
                                @endforeach
                            </div>
                            @endif

                            @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form action="{{ route('sipensi.login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="(Guru Piket, Kesiswaan, Wali Kelas, Kepala Sekolah)">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password (Kode Keamanan)</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                            <script>
                                const togglePassword = document.querySelector("#togglePassword");
                                const password = document.querySelector("#password");

                                togglePassword.addEventListener("click", function() {
                                    const type = password.getAttribute("type") === "password" ? "text" : "password";
                                    password.setAttribute("type", type);
                                    this.innerHTML = type === "password" ?
                                        '<i class="fa fa-eye"></i>' :
                                        '<i class="fa fa-eye-slash"></i>';
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@include('layout.footer')
