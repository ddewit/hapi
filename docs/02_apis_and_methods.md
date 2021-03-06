# Supported APIs and their methods

HaPi supports the following Harvest APIs:

## Accounts

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Accounts.md  
HaPi status: `implemented`

 * `\Harvest\Api\Account::whoAmI()`
   User and account information of the current user.

## Client Contacts

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Client%20Contacts.md  
HaPi status: `untested`

 * `\Harvest\Api\Contact::all([ DateTime $updated_since ])`  
   Get all contacts for an account.
 * `\Harvest\Api\Contact::allContactsForClient(int $client_id, [ DateTime $updated_since ])`  
   Get all contacts for a client.
 * `\Harvest\Api\Contact::get(int $contact_id)`  
   Get a client contact.
 * `\Harvest\Api\Contact::create(Model\ClientContact $client_contact)`  
   Create a new client contact.
 * `\Harvest\Api\Contact::update(Model\ClientContact $client_contact)`  
   Update a client contact.
 * `\Harvest\Api\Contact::delete(int $contact_id)`  
   Delete a client contact.
   
## Clients

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Clients.md  
HaPi status: `implemented`

 * `\Harvest\Api\Client::all([ DateTime $updated_since ])`  
   Get all clients.
 * `\Harvest\Api\Client::get(int $client_id)`  
   Get a client.
 * `\Harvest\Api\Client::create(Model\Client $client)`  
   Create a new client.
 * `\Harvest\Api\Client::update(Model\Client $client)`  
   Update a client.
 * `\Harvest\Api\Client::toggle(int $client_id)`  
   (De)activate an existing client.
 * `\Harvest\Api\Client::delete(int $client_id)`  
   Delete a client.
   
## Estimates

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Estimates.md  
HaPi status: `wontfix`

 * Currently, the Harvest API does not have support for Estimates. They do not have a timeframe for deploying it. So HaPi does not support this either. Sorry.

## Expense Categories

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Expense%20Categories.md  
HaPi status: `todo`

 * `\Harvest\Api\ExpenseCategory::all(DateTime $updated_since)`  
   Get all expense categories.
 * `\Harvest\Api\ExpenseCategory::get(int $expense_category_id)`  
   Get an expense category.
 * `\Harvest\Api\ExpenseCategory::create(Model\ExpenseCategory $expense_category)`  
   Create a new expense category.
 * `\Harvest\Api\ExpenseCategory::update(Model\ExpenseCategory $expense_category)`  
   Update an expense category.
 * `\Harvest\Api\ExpenseCategory::toggle(int $expense_category_id)`  
   (De)activate an existing expense category.
 * `\Harvest\Api\ExpenseCategory::delete(int $expense_category_id)`  
   Delete an expense category.

## Expense Tracking

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Expense%20Tracking.md  
HaPi status: `todo`

 * `\Harvest\Api\Expense::get(int $expense_id)`  
   Get an expense.
 * `\Harvest\Api\Expense::getReceipt(int $expense_id)`  
   Get a receipt image associated with an expense.
 * `\Harvest\Api\Expense::create(Model\Expense $expense)`  
   Create a new expense.
 * `\Harvest\Api\Expense::update(Model\Expense $expense)`  
   Update an expense.
 * `\Harvest\Api\Expense::attachReceipt(int $expense_id, string $image_path)`  
   Attach a receipt image to an expense.
 * `\Harvest\Api\Expense::delete(int $expense_id)`  
   Delete an expense.

## Invoice Item Categories

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Invoice%20Categories.md  
HaPi status: `todo`

 * `\Harvest\Api\InvoiceItemCategory::all()`  
   Get all invoice item categories.
 * `\Harvest\Api\InvoiceItemCategory::create(Model\InvoiceItemCategory $invoice_item_category)`  
   Create a new invoice item category.
 * `\Harvest\Api\InvoiceItemCategory::update(Model\InvoiceItemCategory $invoice_item_category)`  
   Update an invoice item category.
 * `\Harvest\Api\InvoiceItemCategory::delete(int $invoice_item_category_id)`  
   Delete an invoice item category. Please note that you can only delete categories you created yourself.

Notes:

 * For these calls to work, you have to enable the Invoice feature for your account.
 * The Invoice Item Categories in Harvest does not support getting a single category.

## Invoice Messages

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Invoice%20Messages.md  
HaPi status: `todo`

 * `\Harvest\Api\InvoiceMessage::allMessagesForInvoice(int $invoice_id)`  
   Get all messages for given invoice.
 * `\Harvest\Api\InvoiceMessage::getForInvoice(int $invoice_message_id, int $invoice_id)`  
   Get a single message from given invoice.
 * `\Harvest\Api\InvoiceMessage::sendInvoice(Model\InvoiceMessage $invoice_message, int $invoice_id)`  
   Send a message for given invoice.
 * incomplete.

Notes:

 * For these calls to work, you have to enable the Invoice feature for your account.
 
## Invoice Payments

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Invoice%20Payments.md  
HaPi status: `todo`

 * `\Harvest\Api\InvoicePayment::paymentsForInvoice(int $invoice_id)`  
   Get all payments for given invoice.
 * `\Harvest\Api\InvoicePayment::get(int $invoice_payment_id, int $invoice_id)`  
   Get a single payment from given invoice.
 * `\Harvest\Api\InvoicePayment::create(Model\InvoicePayment $invoice_payment, int $invoice_id)`  
   Create a new payment for given invoice.
 * `\Harvest\Api\InvoicePayment::delete(int $invoice_payment_id, int $invoice_id)`  
   Delete given payment from given invoice.

## People

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/People.md  
HaPi status: `untested`

 * `\Harvest\Api\Person::all([ DateTime $updated_since ])`  
   Get all users.
 * `\Harvest\Api\Person::get(int $user_id)`  
   Get a user.
 * `\Harvest\Api\Person::create(Model\User $user)`  
   Create a new user.
 * `\Harvest\Api\Person::update(Model\User $user)`  
   Update a user.
 * `\Harvest\Api\Person::toggle(int $user_id)`  
   Toggle a user.
 * `\Harvest\Api\Person::delete(int $user_id)`  
   Delete a user.

## Projects

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Projects.md  
HaPi status: `implemented`

 * `\Harvest\Api\Project::all([ DateTime $updated_since ])`  
   Get all projects.
 * `\Harvest\Api\Project::allProjectsForClient(int $client_id)`  
   Get all projects for client.
 * `\Harvest\Api\Project::get(int $project_id)`  
   Get a project.
 * `\Harvest\Api\Project::create(Model\User $project)`  
   Create a new project.
 * `\Harvest\Api\Project::update(Model\User $project)`  
   Update a project.
 * `\Harvest\Api\Project::toggle(int $project_id)`  
   Toggle a project.
 * `\Harvest\Api\Project::delete(int $project_id)`  
   Delete a project.

## Tasks

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Tasks.md  
HaPi status: `untested`

 * `\Harvest\Api\Task::all([ DateTime $updated_since ])`  
   Get all tasks.
 * `\Harvest\Api\Task::get(int $task_id)`  
   Get a task.
 * `\Harvest\Api\Task::create(Model\Task $task)`  
   Create a new task.
 * `\Harvest\Api\Task::update(Model\Task $task)`  
   Update a task.
 * `\Harvest\Api\Task::activate(int $task_id)`  
   Activate a task.
 * `\Harvest\Api\Task::delete(int $task_id)`  
   Delete a task.
   
## Task Assignments

Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Task%20Assignment.md  
HaPi status: `untested`

 * `\Harvest\Api\TaskAssignment::allForProject(int $project_id, [ DateTime $updated_since ])`  
   Get all task assignments for given project.
 * `\Harvest\Api\TaskAssignment::getForProject(int $task_assignment_id, int $project_id)`  
   Get a task assignment.
 * `\Harvest\Api\TaskAssignment::assignToProject(int $task_assignment_id, int $project_id)`  
   Assign a task assignment to given project.
 * `\Harvest\Api\TaskAssignment::createAndAssignToProject(Moderl\TaskAssignment $task_assignment, int $project_id)`  
   Crea a task assignment and assign it to given project.
 * `\Harvest\Api\TaskAssignment::update(Model\Task $task_assignment)`  
   Update a task assignment.
 * `\Harvest\Api\TaskAssignment::delete(int $task_assignment_id, int $project_id)`  
   Delete a task assignment.
   
## My API is missing

No worries, we're adding more as we're progressing. It's our target to support all API's in the near future.