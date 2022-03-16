<?php
include "./services/authentication.php";
include "navbar.php";
include "./config/config.php";
include "./services/dbFunctions.php";
redirectOut();

$nomenclature = getNomenclatureItems();
$json = $nomenclature["result"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>jsTree test</title>
  <!-- 2 load the theme CSS file -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
</head>
<body>
<!-- 3 setup a container element -->
<div id="jstree">
  <!-- in this example the tree is populated from inline HTML -->
  <!-- <ul>
    <li>Root node 1
      <ul>
        <li id="child_node_1">Child node 1</li>
        <li>Child node 2</li>
      </ul>
    </li>
    <li>Root node 2</li>
  </ul> -->
</div>
<button>demo button</button>

<!-- 4 include the jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<!-- 5 include the minified jstree source -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script>
  $(function () {
    // 6 create an instance when the DOM is ready
    // $('#jstree').jstree();
    $("#jstree").jstree({
      "core" : {
        "check_callback" : true,
        "data" :  <?php echo "$json";?>
      },
      "plugins" : [ "contextmenu" ]
    });

    // 7 bind to events triggered on the tree
    $('#jstree').on("rename_node.jstree", function(e, data) {
      alert(data.node.id);
      var request = new XMLHTTpRequest();
      request.open('post', 'nomenclature.php');
      request.setRequestHeader();   
      //set request header
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      var oldValue = data.old;
      var newValue = data.text;
      request.send("oldValue="+oldValue, "newValue="+newValue);
      alert("rename successfully");
      // echo "rename successfully";   
    });

    // 8 interact with the tree - either way is OK
    $('button').on('click', function () {
      $('#jstree').jstree(true).select_node('child_node_1');
      $('#jstree').jstree('select_node', 'child_node_1');
      $.jstree.reference('#jstree').select_node('child_node_1');
    });
  });
</script>
</body>
</html>
 