
<div class="container" align="right">
	{{ link_to('/logout', 'Logout') }}
</div>
<div class="container">
    <p><h2>Profile of {{ user.name|escape }}:</h2></p>
</div>
<div class="container">
	<ul>
	  <li>ID: {{ user.id }}</li>
	  <li>GitHub ID: {{ user.github_id }}</li>
	  <li>Name: {{ user.name|escape }}</li>
	  <li>URL: {{ user.html_url|escape }}</li>
	  <li>Avatar: <img src="{{ user.avatar_url|escape }}" alt="Avatar" height="42" width="42"></li>
	</ul>
</div>

