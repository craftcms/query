var $form = $('#query-form');
var $sql = $('#query-sql');
var $results = $('#query-result');

$form.on('submit', function(ev) {
    ev.preventDefault();
    Craft.postActionRequest('query/default/execute', {sql: $sql.val()}, function(response, textStatus) {

        if (textStatus == 'success') {

            if (response.success) {

                if (response.result.length) {
                    var html = '<table class="data">' +
                        '<thead>' +
                        '<tr>';

                    for (var key in response.result[0]) {
                        html += '<th scope="col">' +
                            key +
                            '</th>';
                    }

                    html += '</tr>' +
                        '</thead>' +
                        '</tbody>';

                    for (var i = 0; i < response.result.length; i++) {
                        html += '<tr>';
                        for (var cell in response.result[i]) {
                            html += '<td style="vertical-align: top"><pre>' +
                                response.result[i][cell] +
                                '</pre></td>';
                        }
                        html += '</tr>';
                    }

                    html += '<tbody>' +
                        '</table>';

                    $results.html(html);
                }
            } else {
                $results.html('<div class="error">' + response.result + '</div>');
            }

        }
    });
});
