<? 
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('slides', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/slides'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/slides'));
    exit;
}
$page='slides';
include('_header.php'); 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <form method="POST" action="<?=action_url()?>" enctype="multipart/form-data">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Slides</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Language *</label>
                            <select name="lang_code" class="form-control" required>
                                <option value="" disabled selected>-- Please select --</option>
                                    <? 
                                        foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $key) {
							                $key=basename($key, '.php');
                                            echo '<option '.($find['lang_code']==$key?'selected':'').' value="'.$key.'">'.$code_to_lang[$key].'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image *</label>
                            <input type="file" name="file_image" class="form-control" accept="image/png,image/jpg,image/jpeg,image/gif">
                            <small class="text-danger">** Don't touch here to not change</small>
                            <br/>
                            <img src="<?=upload_url('slides/'.$find['image'])?>" style="height: 80px;width:auto;" class="img-fluid">
                            <br/>
                            <input type="hidden" value="<?=$find['image']?>" name="old_image">
                        </div>
                        <div class="form-group">
                            <label>Title (Not required)</label>
                            <input type="text" name="title" value="<?=$find['title']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Text (Not required)</label>
                            <input type="text" name="text" value="<?=$find['text']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option <?=($find['status']==1?'selected':'')?> value="1">Enable</option>
                                <option <?=($find['status']==0?'selected':'')?> value="0">Disable</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Order *</label>
                            <input required type="number" name="order" class="form-control" value="1">
                        </div>
                        
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Slides</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$find['id']?>">
                    <input type="hidden" name="form" value="edit_slides">
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>