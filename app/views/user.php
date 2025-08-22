<?php /** @var \League\Plates\Template\Template $this */ ?>

<?php $this->layout('master', ['file'=> $name, 'title' => $title]) ?>

<link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
<script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>
<style>
    .tabulator-print-header, tabulator-print-footer{
        text-align:center;
    }
</style>
<section>
    <h2>Usuários</h2>
    <div class="users-container" style="margin-top: 20px;">

        <div>
            <select id="filter-field">
                <option></option>
                <option value="id">Id</option>
                <option value="nome">Nome</option>
                <option value="email">Email</option>
                <option value="tipo">Tipo</option>
                
            </select>
            <select id="filter-type">
                <option value="=">=</option>
                <option value="<"><</option>
                <option value="<="><=</option>
                <option value=">">></option>
                <option value=">=">>=</option>
                <option value="!=">!=</option>
                <option value="like">like</option>
            </select>
            <input id="filter-value" type="text" placeholder="value to filter">
            <button id="filter-clear">Clear Filter</button>


            <button id="download-csv">Download CSV</button>
            <button id="print-table">Print Table</button>

        </div>

        <div id="user-table" class="tabulator-default"></div>
    </div>
</section>

<script>
const tableData = <?= json_encode($users, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

//Define variables for input elements
var fieldEl = document.getElementById("filter-field");
var typeEl = document.getElementById("filter-type");
var valueEl = document.getElementById("filter-value");

//Custom filter example
function customFilter(data){
    return data.car && data.rating < 3;
}

//Trigger setFilter function with correct parameters
function updateFilter(){
  var filterVal = fieldEl.options[fieldEl.selectedIndex].value;
  var typeVal = typeEl.options[typeEl.selectedIndex].value;

  var filter = filterVal == "function" ? customFilter : filterVal;

  if(filterVal == "function" ){
    typeEl.disabled = true;
    valueEl.disabled = true;
  }else{
    typeEl.disabled = false;
    valueEl.disabled = false;
  }

  if(filterVal){
    table.setFilter(filter,typeVal, valueEl.value);
  }
}

//Update filters on value change
document.getElementById("filter-field").addEventListener("change", updateFilter);
document.getElementById("filter-type").addEventListener("change", updateFilter);
document.getElementById("filter-value").addEventListener("keyup", updateFilter);

//Clear filters on "Clear Filters" button click
document.getElementById("filter-clear").addEventListener("click", function(){
  fieldEl.value = "";
  typeEl.value = "=";
  valueEl.value = "";

  table.clearFilter();
});


const table = new Tabulator("#user-table", {
    data: tableData,
    height: "90%", // altura fixa
    layout: "fitColumns",
    movableColumns: true,
    resizableColumns: true,
    columns: [
        { title: "ID", field: "id", width: 50 },
        { title: "Nome", field: "nome" },
        { title: "Email", field: "email" },
        { title: "Tipo", field: "tipo" },
    ],
});

document.getElementById("download-csv").addEventListener("click", function(){
    table.download("csv", "data.csv");
});

document.getElementById("print-table").addEventListener("click", function(){
   table.print(false, true);
})
</script>
