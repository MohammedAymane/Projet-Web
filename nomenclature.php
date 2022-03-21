<?php
  include "./services/authentication.php";
  include "navbar.php";
  include "./config/config.php";
  include "./services/dbFunctions.php";
  redirectOut();
  redirectNoneAdmin();
  $nomenclature = getNomenclatureItems();
  $json = $nomenclature["result"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>jsTree test</title>
  <!--load the theme CSS file -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/semantic-ui/2.2.4/semantic.min.css">
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<!--setup a container element -->
<div class="ui container m-margin-top-large" style>
  <div class="ui top attached segment">
    <div class="ui stackable secondary four item menu">

      <button class="ui labeled icon button" onclick="tree_create();">
        <i class="file icon"></i>
        Créer
      </button>

      <button class="ui labeled icon button" onclick="tree_rename();">
        <i class="right undo icon"></i>
        Renomer
      </button>

      <button class="ui labeled icon button" onclick="tree_delete();">
        <i class="right trash alternate icon"></i>
        Supprimer
      </button>

      <div class="right menu">
        <div class="ui search">
          <div class="ui icon input">
            <input class="prompt" type="text" id="search_bar" placeholder="Chercher">
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


<!--include the jQuery library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<!--include the minified jstree source -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script>

  function tree_create() {
    var ref = $('#jstree').jstree(true),
      sel = ref.get_selected();
    if(!sel.length) { return false; }
    sel = sel[0];
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

    var node = ref.get_node(sel[0]);

    if(confirm("Do you really want to delete " + node.text + " ?")){
      ref.delete_node(sel);
    } 
  };


  function post(action, data) {
    let request = new XMLHttpRequest();   
    request.open('post', 'nomenclatureHandler.php');
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.send("id="+data.node.id+"&parent="+data.node.parent+"&text="+data.node.text+"&action="+action);
  }
  //bind to events triggered on the tree
  $(function () {

    // search node in the treee
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
        "animation" : 100,
        "expand_selected_onload" : true,
        "themes" : {
          "variant" : "large",
          "stripes" : true  //the tree background is striped
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

  });
</script>
</body>
</html>
 