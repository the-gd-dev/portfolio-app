// pagination handeling
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    var url = $(this).attr('data-href');
    $.get(url, function (data) {
        hideTableLoader($tableWrapper);
        $tableWrapper.html(data.appendHtml);
    });
});

// Search Box
$(document).on('input', '#search-data', function (e) {
    e.preventDefault();
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    var url = $(this).attr('data-action');
    var inputVal = $(this).val().trim();
    $.get(url + '?search=' + inputVal, function (data) {
        $tableWrapper.html(data.appendHtml);
    });
});

//function to show loader
function showTableLoader($wrapper) {
    
        const loader = `<div class="text-center" id="loader">
                <div class="spinner-border spinner-border-lg icons-loader" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;
        $wrapper.html(loader);
    
}

//function to hide loader
function hideTableLoader($wrapper) {
    if ($wrapper.find('#loader')) {
        $wrapper.find('#loader').remove();
        $wrapper.show();
    }
}
//initial table load
$(document).ready(function(){
    const $tableWrapper = $('#dataListing')
    showTableLoader($tableWrapper);
    $.get('',function (data) {
        hideTableLoader($tableWrapper);
        $tableWrapper.html(data.appendHtml);
        $('[data-toggle="tooltip"]').tooltip();
    });
    
})