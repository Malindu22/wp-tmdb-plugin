<?php
$default__tab = null;
$__tab = isset($_GET['tab']) ? $_GET['tab'] : $default__tab;
/// Tmdb Api key 
$API_KEY = 'fe820d7cf8a922a22d399cad5db275cc';
add_action( 'template_redirect', 'wpse149613_form_process' );
?>
<!-- Our admin page content should all be inside .wrap -->
<div class="wrap">
  <!-- Print the page title -->
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <!-- Here are our tabs -->
  <nav class="nav-tab-wrapper">
    <a href="?page=admin.php" class="nav-tab <?php if($__tab===null):?>nav-tab-active<?php endif; ?>">Default Tab</a>
    <a href="?page=admin.php&tab=settings" class="nav-tab <?php if($__tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
    <a href="?page=admin.php&tab=tools" class="nav-tab <?php if($__tab==='tools'):?>nav-tab-active<?php endif; ?>">Tools</a>
  </nav>

  <div class="tab-content">
  <?php switch($__tab) :
    case 'settings':
      __mg__settings__cont(); //Put your HTML here
      break;
    case 'tools':
      $args = array(
        'style'       => 'list',
        'hide_empty'  => 0,
        );
        // $categories = wp_dropdown_categories( $args ); 
        // foreach ($categories as $sse) {
        //  var_dump($sse);
        // }
        $categories = get_categories( $args );
        foreach ( $categories as $category ) :
      
          echo  $category->term_id . ' '. $category->name. '<br>' ;
      
        endforeach;
      // echo 'Tools'.var_dump($categories);
      break;
    default:
      echo 'Default tab';
      break;
  endswitch; ?>
  </div>
</div>

<?php

 function __mg__settings__cont() {  
  if (isset($_POST['tmdb_key']) && isset($_POST['act_key'])) {
    $__tmdb_key = $_POST['tmdb_key'];
    $__act_key = $_POST['act_key'];
      $tmdb ='_DB_Key';
        if(!get_option($tmdb)){
           add_option( $tmdb, $__tmdb_key , $autoload = 'yes' );
        }
           update_option( $tmdb,  $__tmdb_key , $autoload = 'yes' );
      $__MG_act ='_ACT_MG_Key';
        if(!get_option($__MG_act)){
           add_option( $__MG_act, $__act_key , $autoload = 'yes' );
        }
           update_option( $__MG_act, $__act_key, $autoload = 'yes' );
          // echo'<script> window.setTimeout( function() {
          //   window.location.reload();
          // }, 500); </script>';
      echo '<div class="updated"><p>Update successfull ! </p></div>';
  }
    $__MG_DB_key = get_option('_DB_Key');
    $__MG_key = get_option('_ACT_MG_Key');
   ?>
    <div class="wrap">
        <h2>Settings</h2>       
        <form method="post" action="?page=admin.php&tab=settings">
            <div class="row">
              <div class="p-3">
                <lable class="p-r">TMDB Api Key : </lable>
                <input value="<?php echo $__MG_DB_key?>" class="regular-text code" type="text" name="tmdb_key" id="tmdb_key" />
              </div>
              <div class="p-3">
                <lable class="p-r">Plugin Activation key : </lable>
                <input value="<?php echo $__MG_key?>" class="regular-text code" type="text" id="act_key" name="act_key" />
              </div>
            </div>
              <input type="submit" value="Save Changes" name="submit" id="submit" class="button button-primary" />
        </form>
    </div> 
<?php
}

?>

