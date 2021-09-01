<?
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('what_offer', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/we_offer'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/we_offer'));
    exit;
}
$page='we_offer';
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
                <form method="POST" action="<?=action_url()?>">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">We offer</h6>
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
                            <label>Title *</label>
                            <input required type="text" name="title" value="<?=$find['title']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Content *</label>
                            <textarea class="form-control" name="text" id="editor" style="height: 300px;"><?=htmlspecialchars($find['text'])?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Order</label>
                            <input required type="number" name="order" class="form-control" value="<?=$find['order']?>">
                        </div>
                        
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">We offer</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$find['id']?>">
                    <input type="hidden" name="form" value="edit_we_offer">
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>