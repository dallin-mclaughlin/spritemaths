# About spritemaths Laravel and Vue version

This is the second version of [spritemaths](https://github.com/dallin-mclaughlin/prototype-spritemaths).

The second edition includes php, vue and mysql. Vue and tailwindcss made it easy to make the UI impressive and interactive. It worked well with Mathlive even since Mathlive's recent updates. Although I did have to rewrite the code in some parts to make sure Mathlive was still compatible.

## Code used from outside libraries

-   [Mathlive](https://cortexjs.io/) for math input fields and math display candy.
-   [php math parser](https://github.com/mossadal/math-parser).
-   [function plotter](http://mauriciopoppe.github.io/function-plot/) for javascript and typescript

## Different View of spritemaths

![Alt text](./images/Dashboard.png "Dashboard Screen")

This is the Dashboard screen. After logging in the user sees two panels. The upper panel contains previously saved tests that can be revisited. The lower panel contains the tests available to the user.

![Alt text](./images/Quiz.png "Quiz Screen")

This is the Quiz screen. Here a user will input their answers. The user can cycle through the available questions in the quiz. They have the choice to save the quiz to come back to it later, or have their quiz marked by the server marking script.

![Alt text](./images/Results.png "Results Screen")

This is the Results screen. The user can see how many questions that were correct and incorrect. For incorrect or incomplete answers the page includes a drop down so that users can see how the question is answered correctly.

![Alt text](./images/Function_Plot.png "Function Plot")
This is the Quiz screen. This shows the addition of the function plot display.

![Alt text](./images/Addition.png "Addition Class")
This is the code. This shows the Addition Class which inherits basic properties and functions from the Question class.

![Alt text](./images/Addition_2.png "Addition Class")
This is the code. The addition class again.

![Alt text](./images/QuizController.png "Quiz Controller")
This is the code. This shows a segment of the Quiz Controller. It contains the logic for validating the request data.
