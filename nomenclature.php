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
    $("#jstree").jstree({
      "core" : {
        "multiple" : false,
        "animation" : 0,
        "themes" : {
          "variant" : "large",
          "expand_selected_onload" : true,
          "stripes" : true 
        },
        "check_callback" : true,
        "data" :  <?php echo "$json";?>
      },
      "plugins" : [ "contextmenu","unique", "search"]
    });

    var to = false;
    $('#jstree').keyup(function () {
      if(to) { clearTimeout(to); }
      to = setTimeout(function () {
        var v = $('#jstree').val();
        $('#jstree').jstree(true).search(v);
      }, 250);
    });

    // 7 bind to events triggered on the tree
    function post(action, data) {
      let request = new XMLHttpRequest();   
      request.open('post', 'nomenclatureHandler.php');
      request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      request.send("id="+data.node.id+"&parent="+data.node.parent+"&text="+data.node.text+"&action="+action);
      // alert(action + " successfully");
    }

    $('#jstree').on("rename_node.jstree", function(e, data) {
      post("update", data);
    })
    
    $('#jstree').on("create_node.jstree", function(e, data) {
      post("create", data);
    });

    $('#jstree').on("delete_node.jstree", function(e, data) {
      post("delete", data);
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
 