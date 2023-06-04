<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-4 shadow rounded bg-light text-center">
            <form action="../../public/index.php/user?action=passwordResetSendMail" method="post">
                <div class="my-2">
                    <label for="email" class="form-label">Adresse E-mail</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <div class="my-3">
                    <input type="submit" value="Confirmer" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>