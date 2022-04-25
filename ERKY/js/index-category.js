function AppleModel(evt, model) {
                var i, x, tablinks;
                x = document.getElementsByClassName("apple");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < x.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" focus", "");
                }
                document.getElementById(model).style.display = "grid";
                evt.currentTarget.className += " focus";
            }