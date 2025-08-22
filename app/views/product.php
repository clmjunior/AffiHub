<?php /** @var \League\Plates\Template\Template $this */ ?>

<?php $this->layout('master', ['file'=> $name, 'title' => $title]) ?>

<link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
<script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>

<section>
    <h2 style="margin-top:20px;">Produtos</h2>
    <div class="products-container" style="margin-top: 20px;">

        <div class="filter-toolbar">
            <select id="filter-field">
                <option></option>
                <option value="id">ID</option>
                <option value="title">Título</option>
                <option value="category">Categoria</option>
                <option value="price">Preço</option>
                <option value="stock">Estoque</option>
                <option value="material">Material</option>
                <option value="color">Cor</option>
            </select>
            <select id="filter-type">
                <option value="=">Igual a</option>
                <option value="<">Menor que</option>
                <option value="<=">Menor ou igual a</option>
                <option value=">">Maior que</option>
                <option value=">=">Maior ou igual a</option>
                <option value="!=">Diferente de</option>
                <option value="like">Contenha</option>
            </select>
            <input id="filter-value" type="text" placeholder="Valor para filtrar">
            <button id="filter-clear">Limpar Filtro</button>
            <button id="download-csv">Download CSV</button>
            <button id="print-table">Imprimir Tabela</button>
        </div>

        <div id="product-table" class="tabulator-default"></div>
    </div>
</section>

<?php

?>

<script>
    const tableData = <?= json_encode($products['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    const fieldEl = document.getElementById("filter-field");
    const typeEl = document.getElementById("filter-type");
    const valueEl = document.getElementById("filter-value");

    // 1. Define as colunas em uma variável separada
    const columns = [
        {
            title: "Imagem",
            field: "images",
            resizable: false,
            formatter: function(cell) {
                const images = cell.getValue();
                const src = Array.isArray(images) && images.length > 0 ? images[0] : 'https://via.placeholder.com/60';
                return `<img src="${src}" class="tabulator-img-cell">`;
            },
            hozAlign: "center",
            width: 115,
            frozen: true
        },
        { title: "ID", field: "id", width: 60 },
        { title: "Título", field: "title", minWidth: 180 },
        { title: "Preço", field: "price", formatter: "money", formatterParams: { decimal: ",", thousand: ".", symbol: "R$ " }, hozAlign: "right", width: 100 },
        { title: "Estoque", field: "stock", hozAlign: "center", width: 90 },
        { title: "Cor", field: "color", width: 100 },
        { title: "Material", field: "material", width: 120 },
        { title: "Categoria", field: "category", width: 130 },
        { title: "Feito à Mão", field: "handmade", formatter: "tickCross", hozAlign: "center", width: 90 },
    ];

    // 2. Aplica formatter para alinhar verticalmente
    columns.forEach(col => {
        if (!col.formatter) {
            col.formatter = function(cell) {
                const value = cell.getValue();
                return `<div class="cell-vcenter">${value ?? ''}</div>`;
            };
        }
    });

    // 3. Agora sim: cria a tabela
    const table = new Tabulator("#product-table", {
        data: tableData,
        layout: "fitColumns",
        responsiveLayout: "collapse",
        movableColumns: true,
        columns: columns,
    });

    // Filtros
    function updateFilter() {
        const filterVal = fieldEl.value;
        const typeVal = typeEl.value;
        const filter = filterVal === "function" ? customFilter : filterVal;

        if (filterVal) {
            table.setFilter(filter, typeVal, valueEl.value);
        }
    }
    document.getElementById("filter-field").addEventListener("change", updateFilter);
    document.getElementById("filter-type").addEventListener("change", updateFilter);
    document.getElementById("filter-value").addEventListener("keyup", updateFilter);
    document.getElementById("filter-clear").addEventListener("click", () => {
        fieldEl.value = "";
        typeEl.value = "=";
        valueEl.value = "";
        table.clearFilter();
    });

    // CSV e Impressão
    document.getElementById("download-csv").addEventListener("click", () => {
        table.download("csv", "produtos.csv");
    });
    document.getElementById("print-table").addEventListener("click", () => {
        table.print(false, true);
    });
    </script>

    <style>
    .cell-vcenter {
        display: flex;
        align-items: center;
        height: 100%;
    }
</style>

