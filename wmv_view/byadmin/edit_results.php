<?
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('results', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/results'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/results'));
    exit;
}
$page='results';
include('_header.php'); 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add new</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <form method="POST" action="<?=action_url()?>" enctype="multipart/form-data">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Results</h6>
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
                            <img src="<?=upload_url('results/'.$find['image'])?>" style="height: 130px;width:auto;" class="img-fluid">
                            <br/>
                            <input type="hidden" value="<?=$find['image']?>" name="old_image">
                        </div>
                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" value="<?=$find['title']?>" class="form-control">
                        </div>

                        <div class="form-group" style="border:1px dashed black;">
                            <label>Table colums  *</label>
                            <div id="detalis_input">
                                <?php
                                    $ttitles=json_decode($find['table_titles'], TRUE);
                                    foreach ($ttitles as $ttitle) {
                                        echo '<div class="row" style="margin-top:5px;">
                                        <div class="col-10">
                                            <input type="text" name="table_titles[]" placeholder="Title" value="'.$ttitle.'" class="form-control"> 
                                        </div>
                                        <div class="col-2">
                                            <a onclick="$(this).parent().parent().remove();" class="form-control btn btn-danger">X</a>
                                        </div>
                                    </div>';
                                    }
                                ?>
                            </div>
                            <a onclick="return add_detalis_input();" class='form-control btn btn-warning mt-2'>Add colums</a>
                        </div>

                        <div class="form-group">
                            <label>Order *</label>
                            <input required type="number" name="order" class="form-control" value="<?=$find['order']?>">
                        </div>
                        
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Results</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$find['id']?>">
                    <input type="hidden" name="form" value="edit_results">
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function add_detalis_input() {
        $('#detalis_input').append('<div class="row" style="margin-top:5px;"><div class="col-10"><input type="text" name="table_titles[]" placeholder="Title" class="form-control"></div><div class="col-2"><a onclick="$(this).parent().parent().remove();" class="form-control btn btn-danger">X</a></div></div>'+"\n");
    }
</script>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>