# Supported APIs and their methods

HaPi supports the following Harvest APIs:

## Accounts
 * Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Accounts.md
 * HaPi status: `todo`
 
 * `\Harvest\Api\Account::whoAmI()`
   User and account information of the current user.

## Client Contacts
 * Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Client%20Contacts.md
 * HaPi status: `todo`
 
 * `\Harvest\Api\ClientContact::all(DateTime $updated_since)`  
   Get all contacts for an account.
 * `\Harvest\Api\ClientContact::contactsForClient(int $client_id, DateTime $updated_since)`  
   Get all contacts for a client.
 * `\Harvest\Api\ClientContact::get(int $contact_id)`  
   Get a client contact.
 * `\Harvest\Api\ClientContact::create(Model\ClientContact $client_contact)`  
   Create a new client contact.
 * `\Harvest\Api\ClientContact::update(Model\ClientContact $client_contact)`  
   Update a client contact.
 * `\Harvest\Api\ClientContact::delete(int $contact_id)`  
   Delete a client contact.
   
## Clients
 * Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Clients.md
 * HaPi status: `implemented`
 
 * `\Harvest\Api\Client::all(DateTime $updated_since)`  
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
 * Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Estimates.md
 * HaPi status: `wontfix`
 
Currently, the Harvest API does not have support for Estimates. They do not have a timeframe for deploying it. So HaPi does not support this either. Sorry.

## Expense Categories
 * Harvest API docs: https://github.com/harvesthq/api/blob/master/Sections/Expense%20Categories.md
 * HaPi status: `todo`
 
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

`[ more to come soon. ]`