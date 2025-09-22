(function () {
    'use strict';
    /* quill snow editor */
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [{ 'font': [] }],
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'script': 'sub' }, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],

        ['image', 'video'],
        ['clean']                                         // remove formatting button
    ];
    var editorelement =  document.getElementById('editor');
    if (typeof(editorelement) != 'undefined' && editorelement != null)
    {
        var quill = new Quill('#editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        
        // Custom function to display HTML source code
        function toggleSourceView() {
            let isSourceView = $(quill.root).hasClass('ql-source-view');
            if (isSourceView) {
                quill.root.innerHTML = quill.root.textContent;
            } else {
                quill.root.textContent = quill.root.innerHTML;
            }
            $(quill.root).toggleClass('ql-source-view');
        }

        // Add custom source button to the existing toolbar
        var customButton = document.createElement('button');
        customButton.setAttribute('type', 'button');
        customButton.classList.add("editor-source-button");
        customButton.innerHTML = 'Source';
        customButton.onclick = toggleSourceView;
        var toolbar = quill.getModule('toolbar');
        toolbar.container.appendChild(customButton);
    }
    var editor1element =  document.getElementById('editor1');
    if (typeof(editor1element) != 'undefined' && editor1element != null)
    {
        /* quill bubble editor */
        var quill = new Quill('#editor1', {
            modules: {
                toolbar: undefined
            },
            theme: 'bubble'
        });
    }


})();