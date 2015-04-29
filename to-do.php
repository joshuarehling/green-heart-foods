<style type="text/css">
	strike {
		color: #aaa;
	}
</style>

<h1>To-do List</h1>

<h2>Green Heart Foods Context</h2>

<h3>Open Questions</h3>
<ul>
	<li>What happens when trying to create a menu for a day and meal which already has a menu.</li>
	<li>The feature sets document calls for two version of the client view for the daily menu. I don’t think this was in the original scope, can we confirm that it’s needed?</li>
	<li>How long should a users logged in status persist?</li>
</ul>

<h3>admin/clients.php</h3>
<ul>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
	<li>Determine what to do with inactive clients.</li>
</ul>

<h3>admin/create-client.php</h3>
<ul>
	<strike><li>Change ‘submit’ to ‘save’ and ‘cancel’</li></strike>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
</ul>

<h3>admin/create-menu.php</h3>
<ul>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
</ul>


<h3>admin/daily-menu.php</h3>
<ul>
	<strike><li>After creating new meal, page redirects to breakfast</li></strike>
	<strike><li>Determine page context</li></strike>
	<strike><li>Convert checkbox results to text (first letter uppercase and remove underscore);</li></strike>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
	<strike><li>Add print placards link</li></strike>
	<strike><li>Add print menu link</li></strike>
	<strike><li>Display special notes from client if available</li></strike>
	<strike><li>Display picture of meal</li></strike>
	<strike><li>Favorite heart div with ‘like’ count</li></strike>
	<strike><li>Do math for “10 orders serves 150 $750” </li></strike>
	<strike><li>Hide subtract and add buttons for GHF context</li></strike>
</ul>

<h3>admin/daily-menu-print-placards.php</h3>
<ul>
	<strike><li>Determine page content</li></strike>
	<strike><li>Update to-do list with scope</li></strike>
</ul>

<h3>admin/daily-menu-print-menu.php</h3>
<ul>
	<strike><li>Determine page content</li></strike>
	<strike><li>Update to-do list with scope</li></strike>
</ul>

<h3>admin/edit-client.php</h3>
<ul>
	<strike><li>Add hidden inputs for image paths</li></strike>
	<strike><li>Add logic for replacing or keeping existing image paths.</li></strike>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
</ul>


<h3>admin/edit-daily-menu.php</h3>
<ul>
	<strike><li>Write logic for images</li></strike>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
</ul>

<h3>admin/index.php</h3>
<ul>
	<strike><li>Done, nothng needed from Josh Reiling</li></strike>
</ul>

<h3>admin/weekly-menu.php</h3>
<ul>
	<strike><li>Determine page context</li></strike>
	<strike><li>Format dates week dates</li></strike>
	<strike><li>Move ‘create menu’ to bottom</li></strike>
	<strike><li>Add ‘send to client’ button to bottom</li></strike>
	<strike><li>Hook up email script to send link to admin email in database.</li></strike>
	<strike><li>Add status message of sent for review</li></strike>
	<strike><li>Add status message of sent for approved</li></strike>
	<strike><li>Add image to each meal group</li></strike>
	<strike><li>Move view items to bottom of meal group data</li></strike>
	<strike><li>Add static page content</li></strike>
	<strike><li>Review error message placement</li></strike>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<strike><li>Review, clean and comment code</li></strike>
	<li>Test email functionality on live server.</li>
</ul>

<h3>clients/index.php</h3>
<ul>
	<strike><li>Done, nothng needed from Josh Reiling</li></strike>
</ul>

<h3>clients/daily-menu.php (Client Admin)</h3>
<ul>
	<strike><li>Determine page context</li></strike>
	<strike><li>Convert checkbox results to text (first letter uppercase and remove underscore);</li></strike>
	<li>Hook up subtract and add buttons</li>
	<li>Add static page content</li>
	<li>Review error message placement</li>
	<li>Add global structure </li>
	<li>Add div hooks for css</li>
	<li>Review, clean and comment code</li>
	<li>Add print placards link</li>
	<li>Add print menu link</li>
	<li>Display special notes from client if available</li>
	<li>Display picture of meal</li>
	<li>Favorite heart div with ‘like’ count</li>
	<li>Do math for “10 orders serves 150 $750” </li>
	<li>Hide subtract and add buttons for GHF context</li>
</ul>


<h3>clients/daily-menu.php (General User)</h3>
<ul>
	<li>Determine page context</li>
	<li>Hide # of orders</li>
	<li>Hide serving size</li>
	<li>Price per serving</li>
	<li>Hide add/subtract</li>
	<li>Hide special notes</li>
	<li>Hide save/place/edit</li>
</ul>


<h3>clients/weekly-menu.php</h3>
<ul>
	<li>Set dynamic context</li>
	<li>Format dates week dates</li>
	<li>Hide ‘create menu’ to bottom</li>
	<li>Hide ‘send to client’ button to bottom</li>
	<li>Add status message of approved</li>
	<li>Add status message of not approved (eq to sent to client in GHF context.)</li>
	<li>Add image to each meal group</li>
	<li>Move view items to bottom of meal group data</li>
	<li>Add static page content</li>
	<li>Review error message placement</li>
	<li>Add global structure </li>
	<li>Add div hooks for css</li>
	<li>Review, clean and comment code</li>
	<li>Add ‘place order’ button.</li>
	<li>Hook up place order to update database status</li>
	<li>Possibly send email to GHF alerting that it’s been placed?</li>
</ul>


<h3>login/index.php</h3>
<ul>
	<strike><li>Add static page content</li></strike>
	<li>Review error message placement</li>
	<strike><li>Add global structure </li></strike>
	<strike><li>Add div hooks for css</li></strike>
	<li>Review, clean and comment code</li>
</ul>

<h3>root/index.php</h3>
<ul>
	<strike><li>Done, nothing needed from Josh Rehling</li></strike>
</ul>

<h3>Global</h3>
<ul>
	<li>Insert exit() after each Messages:add() and header redirect</li>
</ul>
