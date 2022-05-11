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

    $('#search-keyword .typeahead').bind('typeahead:select', function(ev, suggestion) {
        windowKeywords = suggestion.slug;
    });

    const convertToSlug = function (s) {
        return s.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "") //remove diacritics
                .toLowerCase()
                .replace(/\s+/g, '-') //spaces to dashes
                .replace(/&/g, '-and-') //ampersand to and
                .replace(/[^\w\-]+/g, '') //remove non-words
                .replace(/\-\-+/g, '-') //collapse multiple dashes
                .replace(/^-+/, '') //trim starting dash
                .replace(/-+$/, ''); //trim ending dash
    };

    $(".search-form").on('submit', (e) => { 
        e.preventDefault();
        if (windowKeywords == '') {
            windowKeywords = convertToSlug($('#typeahead').val())
        }
        window.location = home_url + '/' + windowKeywords ;
    });
});