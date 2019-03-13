<h3>March 2019: This site was created in 2010, and is not currently maintained. I am keeping it only for the Judo Community after revising the code in January 2019 to work again after PHP and Database upgrades broke the site. Please do contact me about this site and the ideas it explores  , Lance</h3>
<p>This site is part of a research project into the ranking system used in JUDO and possible alternative methodologies.</p>
<p>Currently, this site is using a modified version of the ELO ranking system. Using the following modifications:</p>
<ul>
    <li>K factor of 40</li>
    <li>The losing player loses half the normal amount</li>
    <li>The starting value for all athletes is 1500</li>
</ul>
<p>* I have recently added an API to the fights data, this is available via the API link in the footer ( <a href="http://rwjl.net/api">http://rwjl.net/api</a> ).</p>
<p>Below is a research poster outlining the research. This poster was presented at the 2nd EJU Research Symposium, held at the European Judo Union Championships 2011.</p>
<a title="View An experimental relative skill based  ranking system for elite level Judo on Scribd" href="http://www.scribd.com/doc/52990309/An-experimental-relative-skill-based-ranking-system-for-elite-level-Judo" style="margin: 12px auto 6px auto; font-family: Helvetica,Arial,Sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-size-adjust: none; font-stretch: normal; -x-system-font: none; display: block; text-decoration: underline;">An experimental relative skill based  ranking system for elite level Judo</a><iframe class="scribd_iframe_embed" src="http://www.scribd.com/embeds/52990309/content?start_page=1&view_mode=list&access_key=key-yl7i29m4vp9hetv7tm8" data-auto-height="true" data-aspect-ratio="0.707514450867052" scrolling="no" id="doc_82271" width="100%" height="600" frameborder="0"></iframe><script type="text/javascript">(function() { var scribd = document.createElement("script"); scribd.type = "text/javascript"; scribd.async = true; scribd.src = "http://www.scribd.com/javascripts/embed_code/inject.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(scribd, s); })();</script>

<p>The events included in the rankings are listed on the righthand side.</p>
<p>Currently 38 known athlete name errors/typos are corrected. All names are also re-encoded to ISO-8859-1 or characters ignored, apostrophes are also removed.</p>

<h3>Draft Introduction</h3>
<p>

- Research into alternative to the IJF ranking list.
<p>
 

In this article I want to introduce a research project I have running over the next two years looking at the IJF Ranking list.
<p>
The International Judo Federation (IJF) has implemented a international ranking system, which as of this year (2010) forms the criteria for qualification for the London 2012 Olympic Games. The ranking list is, to summarise, based on where players place at elite level tournaments. The system was trialed initially within the EJU and is now the sole criteria for selection to the 2012 games.
<p>
 

In 2005, as part of the European Judo Union (EJU) Level 4 coaches qualification (www.judospace.com/ARU links) I did a brief examination of ranking players based on medal position for the -73kg category in my native New Zealand. As part of this I discussed the ranking list I generated (using a very similar method to the current IJF system) with the New Zealand national coach of the time. These discussions along with the list I generated raised questions around the validity of a ranking/selection system based purely on end results of tournaments.

 
<p>
In 2007, I looked again at the ranking list question and investigated as an alternative the ELO ranking system (http://en.wikipedia.org/wiki/Elo_rating_system). The ELO ranking system is used in Chess and commonly in online gaming (such as XBox Live). It is named after its creator Arpad Elo, a Hungarian-born American physics professor. Unlike the IJF list that ranks players based on final position in the event; the ELO system awards ranking points based on the probablity of a player beating another. The ELO system in effect trys to rank players based on the ability of the players they have won or lost to rather than the position in the medal table.

 
<p>
In 2007 I created a prototype website (www.rwjl.net) using the ELO system to rank players that decided to use the system to rank themselves. This website did not prove popular and in 2010 I am recycling the website address and concept to run a research experiment looking at the elite level players in world Judo.

 
<p>
The new RWJL.NET website uses the ELO system to rank players competing in the London 2012 Judo qualification events. The hypothesis is that the ELO system of ranking provides a more accurate/fairer ranking of players than the current IJF position based system. The ELO system can be suggested to resolve by design the problem associated with variance in quality of events. The current IJF system has encountered this problem and a manual intervention was proposed in the case of the OJU World cup; where fewer points were to be awarded than other world cup events. However, this was decided against and the issue still exists at all events. For example at the recently held 2010 Venezuela World Cup the -63kg category had only 10 compeditors. And did not, one can argue, have the calibre of athlete that say the GB World Cup might have.

Within the RWJL system (though not yet implemented), we propose changing the K value depending on the average ranking points of the players in the category at each event. This would provide some adaption for strong events and weaker ones.

 
<p>
The ELO system is designed to award ranking points based on the relative positions of players, so if you were for example to beat someone like Kosei Inoue you would receive considerably more points for that win than if you beat myself for example. Equally, Kosei Inoue would receive fewer points for beating you than he might for beating David Doilliet.

 
<p>
- The methodology used on www.RWJL.NET

 
<p>
The RWJL.NET website will track all the fights held at London 2012 qualification events only. Players start with 1600 points and gain or lose points after each match they fight. ELO ranking is being calculated using the elo_calculator Class from phpclasses (version dated 2005-06-09).

 
<p>
Results are being collected from the TTA software by Matthias Fischer (version 7.0) available via www.ippon.org. These fight results are parsed by the RWJL.NET software and player name, rank, and category stored in a database.

 
<p>
The individual fight results will be stored in a format that will allow them to be used to apply alternative ranking systems or variations to be made during or after this research study concludes. This is important as it will provide a resource that other researchers can use to investigate this area without having to collect the raw data again.

 
<p>
- Discussion

 
<p>
Further investigation needs to be conducted into the various ranking systems used in sport and how these might be applied to international Judo.
<p>
This research project will provide an investigation into an alternative to the current ranking system being used by the IJF. Depending on the analysis results at the end of the qualification period this study will provide evidence to support the continued use of the current system or change to an alternative system. The raw data and software created by this project can be used to test alternative ranking systems.

 
<p>
There are many variables and considerations that are not covered in this research at this point. For example, how to contend with athletes changing category. In the current RWJL software, the ranking points they accrued in one category will transfer to their second category. The IJF system by contrast maintains different ranks for different weight classes, For example Sean Choi of new Zealand has competed in two weight classes and on the IJF ranking list is included in both weights. Is this the right approach? Investigation and discussion would/will be required.

 
<p>
- Summary and conclusion

 
<p>
This research project's primary goal is to test an alternative ranking system for elite level Judo. This will involve comparing the current IJF ranking solution with the system under test to allow discussion and decisions to be made about the quality of the ranking list system. It shall provide evidence to support the currently used or a new ranking system.

 
<p>
The author hopes that this research project will provide evidence and focus for a discussion around the IJF ranking list and Olympic Selection criteria.

 
<p>
Please address all comments, questions, suggestions to Lance Wicks at the following email address: lw@judocoach.com

 
</pre>