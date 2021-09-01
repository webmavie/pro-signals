<? 
$page='options';
include('_header.php'); 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Options</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Reload page</a>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <form method="POST" action="<?=action_url()?>" enctype="multipart/form-data">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Options</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Logo *</label>
                            <input type="file" name="file_image" class="form-control" accept="image/png,image/jpg,image/jpeg,image/gif">
                            <small class="text-danger">** Don't touch here to not change</small>
                            <br/>
                            <img src="<?=upload_url(getOption('logo'))?>" style="height: 50px;width:auto;" class="img-fluid">
                            <br/>
                        </div>
                        <div class="form-group">
                            <label>Download File *</label>
                            <input type="file" name="file_pdf" class="form-control">
                            <small class="text-danger">** Don't touch here to not change</small>
                            <br/>
                            <p>Direct adress: <a target="_blank" href="<?=upload_url(getOption('download_file'))?>"><?=upload_url(getOption('download_file'))?></a></p>
                            <p>Secret adress: <a target="_blank" href="<?=action_url(array('act' => 'download', 'hash' => getOption('download_hash')))?>"><?=action_url(array('act' => 'download', 'hash' => getOption('download_hash')))?></a></p>
                            <br/>
                        </div>
                        <div class="form-group">
                            <label>Site name *</label>
                            <input required type="text" name="site_name" class="form-control" value="<?=getOption('site_name')?>">
                        </div>
                        <div class="form-group" style="border:1px dashed black;">
                            <label>Site title *</label>
                            <?php
                                foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $flangname) {
                                    $basename=basename($flangname, '.php');
                                    echo '<br/><label>'.$code_to_lang[$basename].'</label><input required type="text" name="site_title['.$basename.']" class="form-control" value="'.getOption('site_title', $basename).'">';
                                }
                            ?>
                        </div>
                        <div class="form-group" style="border:1px dashed black;">
                            <label>Site slogan *</label>
                            <?php
                                foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $flangname) {
                                    $basename=basename($flangname, '.php');
                                    echo '<br/><label>'.$code_to_lang[$basename].'</label><input required type="text" name="site_slogan['.$basename.']" class="form-control" value="'.getOption('site_slogan', $basename).'">';
                                }
                            ?>
                        </div>
                        <div class="form-group" style="border:1px dashed black;">
                            <label>Description  *</label>
                            <?php
                                foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $flangname) {
                                    $basename=basename($flangname, '.php');
                                    echo '<br/><label>'.$code_to_lang[$basename].'</label><textarea name="site_description['.$basename.']" class="form-control">'.getOption('site_description', $basename).'</textarea>';
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Keywords *</label>
                            <input required type="text" name="site_keywords" class="form-control" value="<?=getOption('site_keywords')?>">
                            <small class="text-danger">** Key words separated by commas</small>
                        </div>
                        <div class="form-group">
                            <label>SEO title</label>
                            <input required type="text" name="og_title" class="form-control" value="<?=getOption('og_title')?>">
                        </div>
                        <div class="form-group">
                            <label>SEO description</label>
                            <input required type="text" name="og_description" class="form-control" value="<?=getOption('og_description')?>">
                        </div>
                        <div class="form-group">
                            <label>Site notify message</label>
                            <input required type="text" name="site_notify" class="form-control" value="<?=getOption('site_notify')?>">
                            <small class="text-danger">** Leave blank to close</small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input required type="text" name="email" class="form-control" value="<?=getOption('email')?>">
                        </div>
                        <div class="form-group">
                            <label>Facebook profile adress</label>
                            <input type="text" name="facebook" class="form-control" value="<?=getOption('facebook')?>">
                        </div>
                        <div class="form-group">
                            <label>Instagram profile adress</label>
                            <input type="text" name="instagram" class="form-control" value="<?=getOption('instagram')?>">
                        </div>
                        <div class="form-group">
                            <label>Telegram username</label>
                            <input required type="text" name="telegram_username" class="form-control" value="<?=getOption('telegram_username')?>">
                        </div>
                        <div class="form-group">
                            <label>Whatsapp number</label>
                            <input required type="text" name="whatsapp_number" class="form-control" value="<?=getOption('whatsapp_number')?>">
                        </div>
                        <div class="form-group">
                            <label>Phone number</label>
                            <input required type="text" name="phone_number" class="form-control" value="<?=getOption('phone_number')?>">
                        </div>
                        <div class="form-group">
                            <label>Company adress</label>
                            <input required type="text" name="company_adress" class="form-control" value="<?=getOption('company_adress')?>">
                        </div>
                        <div class="form-group">
                            <label>HTML area (on header)</label>
                            <textarea name="html_area_head" class="form-control"><?=getOption('html_area_head')?></textarea>
                            <small class="text-warning">** It can be used for add-ons such as chat service or website tracking.</small>
                        </div>
                        <div class="form-group">
                            <label>HTML area (on body start)</label>
                            <textarea name="html_area_body_start" class="form-control"><?=getOption('html_area_body_start')?></textarea>
                            <small class="text-warning">** It can be used for add-ons such as chat service or website tracking.</small>
                        </div>
                        <div class="form-group">
                            <label>HTML area (on body end)</label>
                            <textarea name="html_area_body_end" class="form-control"><?=getOption('html_area_body_end')?></textarea>
                            <small class="text-warning">** It can be used for add-ons such as chat service or website tracking.</small>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label>Admin istifadəçi adı *</label>
                            <input required type="text" name="admin_username" class="form-control" value="<?=getOption('admin_username')?>">
                        </div>
                        <div class="form-group">
                            <label>Admin şifrə *</label>
                            <input required type="password" onclick="$(this).prop('type', 'text');" name="admin_password" class="form-control" value="<?=getOption('admin_password')?>">
                        </div>
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Options</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="form" value="options_save">
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>