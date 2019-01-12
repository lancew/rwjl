<h2>RWJL.NET API</h2>
<p>This section of the site provides fellow researchers access to the data collected.<br />
Along with the human readable website; the site provides machine readable data.
</p>

<p>Specifically, the API provides access to the data in "Comma Seperated Value" (.CSV) format.<br />
The API allows access to all the data or a subset of the data.

</p>

<p>
Data is accessed by HTTP request to the /api/export_fights/start/finish" path on this site.<br />
A list of final fight numbers by event is accessed via "/api/fights".<br />
</p>

<h3>Example</h3>
<p>
A user would like to know all the fight results from the 2010 Rotterdam Grand Prix, so they can find out the average number of players per category.
</p>
<p>They visit http://rwjl.net/api/fights and see the fight numbers for each event, a subset is shown below:</p>
<pre>
…
19_ejuworld_cup2010_rome.db: 5039
20_ejuworld_cup2010_baku.db: 5133
21_ejuworld_cup2010_minsk.db: 5264
22_ijfgrand_prix2010_rotterdam.db: 5542
23_ojuworld_cupwcup_samoa2010.db: 5689
24_ijfgrand_prix2010_abu_dhabi.db: 5964
25_juaworld_cup2010_suwon.db: 6240
26_ijfgrand_slam2010_tokyo.db: 6587
...
</pre>

<p>The user can see that the 2010 Rotterdam Grand Prix includes fights 5265 to 5542. The number shown on this page shows the last fight number in that event, so the first fight is the last number of prior event+1.</p>

<p>To obtain the fight data for the 2010 Rotterdam Grand Prix, the user visits http://dev.rwjl/api/export_fights/5265/5542<br />
Below is an example output:
</p>

<img src='/rwjl_data.png' width="90%">

<p>
You can see from the image above the data returned is a CSV list that contains the following data points:
</p>
<ul>
<li>Date:           Date of the event, currently the date of the first day of the event.
<li>Event:          Name of the event
<li>Round:          Round in the event ("Preliminary round","Semifinal","Final","Repechage","Fight for 3rd place")
<li>Category:       Category ("-81", "-48", etc.)
<li>Surname1:       Surname/Family name of Player 1
<li>FirstName1:     Christian/First name of player 1
<li>Nation1:        Country player 1 comes from
<li>Surname2:       Surname/Family name of Player 2
<li>Firstname2:     Christian/First name of player 1
<li>Nation2:        Country player 1 comes from
<li>P1Score:        Score for player one
<li>P2Score:        Score for player two
<li>Winner:         Which player won ("1" or "2")
</ul>

<h3>URLS:</h3>
<ul>
<li>http://rwjl.net/api/ - This page</li>
<li>http://rwjl.net/api/fights - Text list of events and fight numbers</li>
<li>http://dev.rwjl/api/export_fights/xxxx/yyyy - Fight data. x = start number, y = stop number</li>

</ul>