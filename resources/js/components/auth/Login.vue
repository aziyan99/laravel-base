<template>
    <div class="card-group">
        <div class="card p-4">
            <div class="card-body">
                <h1>Masuk</h1>
                <p class="text-muted">Masuk untuk mengakses sistem</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="c-icon cil-envelope-closed"></i>
                        </span>
                    </div>
                    <input class="form-control" type="email" placeholder="Email">
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="c-icon cil-lock-locked"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" autocomplete="off" placeholder="Kata Sandi">
                </div>
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary px-4" type="button">Masuk</button>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-link px-0" type="button">Lupa kata sandi?</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
                <div>
                    <h2>Sign up</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua.</p>
                    <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>
                </div>
            </div>
        </div>
    </div>
</template>
