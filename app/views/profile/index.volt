
<div class="container" align="right">
	{{ link_to('/logout', 'Logout') }}
</div>
<div class="container">
    <p><h2>Profile of {{ user.name|e }}:</h2></p>
</div>
<div class="container">
	<ul>
	  <li>ID: {{ user.id }}</li>
	  <li>GitHub ID: {{ user.github_id }}</li>
	  <li>Name: {{ user.name|e }}</li>
	  <li>URL: {{ user.html_url|e }}</li>
	  <li>Avatar: <img src="{{ user.avatar_url|e }}" alt="Avatar" height="42" width="42"></li>
	  <li>Bearer Token: {{ user.token }}</li>
	</ul>
</div>

