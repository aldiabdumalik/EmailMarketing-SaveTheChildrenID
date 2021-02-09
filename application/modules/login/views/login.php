<!-- Begin page -->
<div class="accountbg" style="background: url('templates/img/bg_login.jpg');background-size: cover;background-position: center;"></div>

<div class="wrapper-page account-page-full">

    <div class="card">
        <div class="card-block">

            <div class="account-box">

                <div class="card-box p-5">
                    <h2 class="text-uppercase text-center pb-4">
                        <a href="#" class="text-success">
                            <img src="<?= base_url() ?>templates/img/sc_logo.svg" alt="" class="img-responsive">
                        </a>
                    </h2>

                    <form id="login-form" class="form-horizontal">

                    <div class="form-group m-b-20 row">
                        <div class="col-12">
                            <label for="login-id">Email</label>
                            <input name="login-id" class="form-control" type="text" id="login-id" required="" autocomplete="off" placeholder="Masukan Email Anda">
                        </div>
                    </div>

                    <div class="form-group row m-b-20">
                        <div class="col-12">
                            <a href="#" class="text-muted float-right" data-target="#login-modal" data-toggle="modal"><small>Lupa password?</small></a>
                            <label for="login-password">Password</label>
                            <input type="password" name="login-password" id="login-password" class="form-control" required="" placeholder="Masukan password Anda">
                        </div>
                    </div>

                    <div class="form-group row text-center m-t-10">
                        <div class="col-12">
                            <button type="submit" id="btn-masuk" class="btn btn-block btn-custom waves-effect waves-light" type="button">Masuk</button>
                        </div>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <p class="account-copyright" data-target="#login-modal">2021 © kadetech.co.id</p>
    </div>

    <div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-uppercase text-center m-b-30">
                        <a href="index.html" class="text-success">
                            <span><img src="<?= base_url() ?>templates/img/sc_logo.svg" alt="" height="50"></span>
                        </a>
                    </h2>
                    <form class="form-horizontal" action="#">
                        <div class="form-group m-b-25">
                            <div class="col-12">
                                <label for="lupa-email">Email</label>
                                <input type="email" name="lupa-email" id="lupa-email" class="form-control" required="" placeholder="Masukan email Anda">
                            </div>
                        </div>
                        <div class="form-group account-btn text-center m-t-10">
                            <div class="col-12">
                                <button id="btn-lupa" class="btn w-lg btn-rounded btn-custom waves-effect waves-light" type="button" style="width:100%;">Kirim</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>