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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.4/semantic.min.css">
</head>
<body>
<!-- 3 setup a container element -->
<div class="ui container">
  <div class="ui top attached segment">
    <div class="ui stackable secondary four item menu">

      <button class="ui labeled icon button" onclick="tree_create();">
        <i class="file icon"></i>
        Create
      </button>

      <button class="ui labeled icon button" onclick="tree_rename();">
        <i class="right undo icon"></i>
        Rename
      </button>

      <button class="ui labeled icon button" onclick="tree_delete();">
        <i class="right trash alternate icon"></i>
        Delete
      </button>

      <div class="right menu">
        <div class="ui search">
          <div class="ui icon input">
            <input class="prompt" type="text" id="search_bar" placeholder="Common passwords...">
            <i class="search icon"></i>
          </div>
          <div class="results"></div>
        </div>
      </div>

    </div>
    
  </div>

  <div class="ui attached segment">
    <div id="jstree" class="padded">
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
  </div>

</div>


<!-- 4 include the jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<!-- 5 include the minified jstree source -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script>

  function tree_create() {
    var ref = $('#jstree').jstree(true),
      sel = ref.get_selected();
    if(!sel.length) { return false; }
    sel = sel[0];
    // sel = ref.create_node(sel, {"type":"file"});
    sel = ref.create_node(sel);

    if(sel) {
      ref.edit(sel);
    }
  };

  function tree_rename() {
    var ref = $('#jstree').jstree(true),
      sel = ref.get_selected();
    if(!sel.length) { return false; }
    sel = sel[0];
    ref.edit(sel);
  };

  function tree_delete() {
    var ref = $('#jstree').jstree(true),
      sel = ref.get_selected();
    if(!sel.length) { return false; }
    ref.delete_node(sel);
  };

  // 7 bind to events triggered on the tree
  function post(action, data) {
    let request = new XMLHttpRequest();   
    request.open('post', 'nomenclatureHandler.php');
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.send("id="+data.node.id+"&parent="+data.node.parent+"&text="+data.node.text+"&action="+action);
    // alert(action + " successfully");
  }

  $(function () {

    // search code 
    var to = false;
    $('#search_bar').keyup(function () {
      if(to) { clearTimeout(to); }
      to = setTimeout(function () {
        var v = $('#search_bar').val();
        $('#jstree').jstree(true).search(v);
      }, 250);
    });

    //  create an instance when the DOM is ready
    $("#jstree").jstree({
      "core" : {
        "multiple" : false,
        "animation" : 0,
        "expand_selected_onload" : true,
        "themes" : {
          "variant" : "large",
          "stripes" : true 
        },

        "check_callback" : function (op, node, par, pos, more) {
                              if(op === "delete_node") {
                                  if (node.parent === '#') {
                                      alert('Cannot delete root! bad guy!!!');
                                      return false;
                                  }
                              }
                          },
        "data" :  <?php echo "$json";?>
      },
      "plugins" : [ "unique", "search"]
    });

    //rename call back function
    $('#jstree').on("rename_node.jstree", function(e, data) {
      post("update", data);
    });

    //create call back function
    $('#jstree').on("create_node.jstree", function(e, data) {
      post("create", data);
    }); 

    //delete call back function
    $('#jstree').on("delete_node.jstree", function(e, data) {
      post("delete", data);
    });

    // interact with the tree - either way is OK
    $('button').on('click', function () {
      $('#jstree').jstree(true).select_node('child_node_1');
      $('#jstree').jstree('select_node', 'child_node_1');
      $.jstree.reference('#jstree').select_node('child_node_1');
    });

  });
</script>
</body>
</html>
 