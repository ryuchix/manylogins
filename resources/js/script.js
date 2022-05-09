$(function() {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };

    let windowKeywords = '';

    const keywords = new Bloodhound({
        datumTokenizer: datum => Bloodhound.tokenizers.whitespace(datum.keywords),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: home_url + "/keywords/api/%QUERY",
            wildcard: "%QUERY",
            // Map the remote source JSON array to a JavaScript object array
            filter: keywords => $.map(keywords, keywords => ({
                keywords: keywords.keywords,
                slug: keywords.slug
            }))
        }
    });

    keywords.initialize();

    $('#search-keyword .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'mylogin-keywords',
            display: 'keywords',
            source: keywords.ttAdapter(),
            templates: {                
                suggestion: function (data) {
                    return '<a class="list-group-item ">' + data.keywords + '</a>';
                }
            }
        }
    );

    //  $('#search-keyword .typeahead').bind('typeahead:change', function(ev, suggestion) {
    //     $('#keyword_search').attr('action', suggestion.split(' ').join('-'));
    // });

    $('#search-keyword .typeahead').bind('typeahead:select', function(ev, suggestion) {
        windowKeywords = suggestion.slug;
    });

    $("#submitBtn").click( function(event) { 
        if (windowKeywords == '') {
            windowKeywords = $('#typeahead').val();
        }
        window.location = home_url + '/' + windowKeywords ;
        // $("#keyword_search").submit(); // Submit the form
    });
});