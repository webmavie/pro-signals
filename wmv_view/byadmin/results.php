<? 
$page='results';
include('_header.php'); 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Results <a href="<?=base_url('byadmin/add_results')?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new</a> <label style="font-size:20px !important;"><input type="checkbox" name="results_show_all_language" value="active" onchange="window.location.href='<?=action_url(array('act' => 'results_show_all_language'))?>';" <?=getOption('results_show_all_language')=='1'?'checked':''?>> Show all languages </label> </h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>
    <div class="row">

    <?php
        $results=$db->get_allrow('results', 'no', 'order', 'ASC');
        foreach ($results as $result) {
    ?>
    <div class="col-xl-3 col-md-12 mb-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><img src="<?=upload_url('results/'.$result['image'])?>" class="img-fluid"/></div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            <?=$code_to_lang[$result['lang_code']]?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?=$result['title']?><br/></div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a class="btn btn-primary btn-sm" style="width: 40%;" href="<?=base_url('byadmin/result_data?id='.$result['id'])?>">View</a>
                <a class="btn btn-warning btn-sm" style="width: 40%;" href="<?=base_url('byadmin/edit_results?id='.$result['id'])?>">Edit</a>
                <a class="btn btn-danger btn-sm" style="width: 15%;" href="<?=action_url(array('act' => 'delete', 'mode' => 'results', 'id' => $result['id']))?>" onclick="return confirm('Are you sure?')">X</a>
            </div>
        </div>
    </div>
    <? } ?>


</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>