<html>
    <head>
        <title>Hello World</title>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
    </head>

    <body>
        <?php
            echo "Hello, World!";
        ?>
        <div id='testdiv'>
                Choice A: <input type="text" id="choice1"/>
                Choice B: <input type="text" id="choice2"/>
                Choice C: <input type="text" id="choice3"/>
                <button
                 type="button"
                 style="background-color:darkblue;color:white;padding:1rem;"
                 value="Submit"
                 onclick="submitit()"
                >
                    Submit
                </button>
        </div>
    </body>
</html>