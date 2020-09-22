<?php
	// Require relevent information for settings.config.inc.php, including functions and database access
	require_once("../includes/news/settings.config.inc.php");
	$pattern = "/(\d+)-(\d+)-(\d+)/i";
	$replacement = "\$3.\$2.\$1";
	// Set $page_name so that the title of each page is correct
	$page_name = PAGENAME_NEWS;
	$datatables_required = 1;
	// Table ID to relate to the datatable, as identified in the <table> and in the <script>, needed to identify which tables to make into datatables
	$datatables_table_id = 'news';
	// No datatable option required for this page
	$datatables_option = null;
	
	$contacts = new Contact();
	
	// Require head content in the page
	require_once("../includes/news/layout.head.inc.php");
	// Requre navigation content in the page
	require_once("../includes/news/layout.navigation.inc.php");
	
?>
			<!-- CONTENT -->
			<p>This section will publish information about technical updates, innovations, and other aspects of the project's life.</p><hr>
			<?php $session->output_message(); ?>
			
			 <?php $counter = 0;
			 foreach($contacts->all as $contact){
				 ?>
 <div data-num class="num page container">
      <div class="row">
        <div class="toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
<h3 class="panel-title" align="center">Update - <?php echo preg_replace($pattern, $replacement, $contact["added"]); ?></h3>	
</div>
            <div class="panel-body" >
              <div class="row">
			  
<div class="col-md-3 col-lg-3"> 
                  <table class="table table-user-information">
                    <tbody>
					   <tr> 
<tr>
                        <td>Date:</td>
                        <td><?php echo preg_replace($pattern, $replacement, $contact["added"]); ?></td>
                      </tr>
					  					   <tr>
                        <td>Added:</td>
                        <td><?php echo $contact["last_name"]; ?></td>
                      </tr>
					  </tr>
					   </tbody>
                  </table>
				  </div>
				  <div class="col-md-9 col-lg-9"><textarea readonly><?php echo $contact["reason"] ?></textarea></div>
				  </div>
				    </div>
			</div><br>
			</div></div></div><hr>
					  
 <?php $counter++;
				// Closing the foreach loop once final item in $contacts has been displayed
				};
					?>
		<div class="paginator" onclick="pagination(event)"></div>
	
<script type="text/javascript">		
var count = <?php echo $counter; ?> //всего записей
var cnt = 2; //сколько отображаем сначала
var cnt_page = Math.ceil(count / cnt); //кол-во страниц

//выводим список страниц
var paginator = document.querySelector(".paginator");
var page = "";
for (var i = 0; i < cnt_page; i++) {
  page += "<span data-page=" + i * cnt + "  id=\"page" + (i + 1) + "\">" + (i + 1) + "</span>";
}
paginator.innerHTML = page;

//выводим первые записи {cnt}
var div_num = document.querySelectorAll(".num");
for (var i = 0; i < div_num.length; i++) {
  if (i < cnt) {
    div_num[i].style.display = "block";
  }
}

var main_page = document.getElementById("page1");
main_page.classList.add("paginator_active");

//листаем
function pagination(event) {
  var e = event || window.event;
  var target = e.target;
  var id = target.id;
  
  if (target.tagName.toLowerCase() != "span") return;
  
  var num_ = id.substr(4);
  var data_page = +target.dataset.page;
  main_page.classList.remove("paginator_active");
  main_page = document.getElementById(id);
  main_page.classList.add("paginator_active");

  var j = 0;
  for (var i = 0; i < div_num.length; i++) {
    var data_num = div_num[i].dataset.num;
    if (data_num <= data_page || data_num >= data_page)
      div_num[i].style.display = "none";

  }
  for (var i = data_page; i < div_num.length; i++) {
    if (j >= cnt) break;
    div_num[i].style.display = "block";
    j++;
  }
}
</script>

					
<?php
	// Requre footer content in the page, including any relevant scripts
	require_once("../includes/news/layout.footer.inc.php");
?>