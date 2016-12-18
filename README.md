# Pre-work - Tip Calculator

"Tip Calculator" is a tip calculator PHP page.

Submitted by: Julian Domingo

Time spent: ~4 hours spent in total

## User Stories

The following **required** functionality is complete:
* [X] User can enter a bill amount, choose a tip percentage, and submit the form to see the tip and total values.
* [X] Tip percentage choices use a PHP loop to output three radio buttons.
* [X] PHP code sets reasonable default values for the form.
* [X] PHP code confirms the presence and correct format of submitted values.
* [X] Page indicates any form errors which need to be fixed.
* [X] Submitted form values are retained when errors or results are shown.

The following **optional** features are implemented:
* [X] Add support for custom tip percentage.
* [X] Add support for splitting the tip and total.

The following **additional** features are implemented:

* [X] Heavily improved UI with Bootstrap and Font Awesome.
* [X] Implemented responsive UI with JQuery.
* [X] Wrote javascript functions to implement alerts.

## Video Walkthrough

Here's a walkthrough of implemented user stories:

<img src='http://i.giphy.com/3oz8xwF7CczzE6by92.gif' title='Video Walkthrough' width='' alt='Video Walkthrough' />

GIF created with [LiceCap](http://www.cockos.com/licecap/).

## Notes

Describe any challenges encountered while building the app.

* This was my first time using PHP, in addition to making a web application. Besides learning the syntax of PHP, JQuery, and Javascript, the most significant challenge I faced was learning when exactly data was submitted, processed, and sent back to the client. For instance, I intially had trouble preventing the calculator from outputting a tip and total amount if the bill subtotal and/or the tip percentage wasn't selected. I solved this problem by learning to process the form only when the server's request method was of type "POST" in addition to learning when to use "isset()" and "empty()". Another significant challenge I faced was having to figure out how to output the radio buttons in a PHP loop.

## License

    Copyright [2016] [Julian Domingo]

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.