\# Architecture \& Design Decisions



\## Overview

The system is built on Laravel MVC with a dedicated service layer for evaluation logic.



\## Database Design



\### Why JSON for `answers.value`?

Each question type produces a different answer shape:

\- Binary/Text → single string: `"yes"`

\- Single choice → option ID: `"4"`

\- Multiple choice → array of IDs: `\["4", "6"]`

\- Number → numeric string: `"7"`



Storing all of these in a single JSON column avoids creating type-specific

answer tables and makes the schema naturally extensible.



\### Why a separate `options` table?

Even number and text questions store their correct answer as an option row

with `is\_correct = true`. This means the evaluation logic never needs to

know where the correct answer lives — it always queries options the same way.



\## Evaluation Logic



All scoring is handled in `app/Services/QuestionEvaluator.php`.



Using a single service class with a `match` expression means:

\- No scoring logic is scattered across controllers or models

\- Adding a new question type only requires adding one method here

\- Controllers stay thin — they just call `$evaluator->evaluate($question, $answer)`



\## Extensibility



To add a new question type (e.g. `ordering`):

1\. Add `ordering` to the `type` enum in the migration

2\. Add a Blade partial in the question form and take view

3\. Add `evaluateOrdering()` in `QuestionEvaluator` and add it to the `match`



No other files need to change.



\## Controllers

\- `QuizController` — CRUD for quizzes

\- `QuestionController` — adding questions with media uploads

\- `AttemptController` — manages attempt lifecycle: start → take → submit → result

