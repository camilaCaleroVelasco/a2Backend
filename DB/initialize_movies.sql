CREATE TABLE moviecategory(
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(255)
);

-- Key = 1
INSERT INTO moviecategory(category)
VALUES('ACTION');

-- Key = 2
INSERT INTO moviecategory(category)
VALUES('ADVENTURE');

-- Key = 3
INSERT INTO moviecategory(category)
VALUES('ANIMATED');

-- Key = 4
INSERT INTO moviecategory(category)
VALUES('COMEDY');

-- Key = 5
INSERT INTO moviecategory(category)
VALUES('DRAMA');

-- Key = 6
INSERT INTO moviecategory(category)
VALUES('MUSIC');

-- Key = 7
INSERT INTO moviecategory(category)
VALUES('FANTASY');

-- Key = 8
INSERT INTO moviecategory(category)
VALUES('HORROR');

-- Key = 9
INSERT INTO moviecategory(category)
VALUES('ROMANCE');

-- Key = 10
INSERT INTO moviecategory(category)
VALUES('SCI-FI');

-- Key = 11
INSERT INTO moviecategory(category)
VALUES('SUSPENSE');

-- Key = 12
INSERT INTO moviecategory(category)
VALUES('THRILLER');


CREATE TABLE movies(
    movie_id INT PRIMARY KEY AUTO_INCREMENT,
    movie_title VARCHAR(255) NOT NULL UNIQUE,
    category_id INT,
    cast TEXT,
    director VARCHAR(255),
    producer VARCHAR(255),
    synopsis TEXT,
    reviews INT,
    picture VARCHAR(255),
    video VARCHAR(255),
    rating_code VARCHAR(255),
    movie_status VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES moviecategory(category_id)
);

INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'ANYONE BUT YOU',
        '9',
        'Sydney Sweeney, Glen Powell, Alexandra Shipp, GaTa, Hadley Robinson',
        'Will Gluck',
        'Alyssa Altman',
        'In the edgy comedy Anyone But You, Bea (Sydney Sweeney) and Ben (Glen Powell) look like the perfect couple, but after an amazing first date something happens that turns their fiery hot attraction ice cold - until they find themselves unexpectedly thrust together at a destination wedding in Australia. So they do what any two mature adults would do: pretend to be a couple.',
        '0',
        'https://imgur.com/f5YT6AU.jpeg',
        'https://www.youtube.com/embed/UtjH6Sk7Gxs?si=_-1rcifRed8528K1',
        'R',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'THE AMERICAN SOCIETY OF MAGICAL NEGROES',
        '7',
        'Justice Jesse Smith, David Alan Grier, An-Li Bogan, Drew Tarver, Michaela Watkins',
        'Kobi Libi',
        'Angel Lopez',
        'THE AMERICAN SOCIETY OF MAGICAL NEGROES is a fresh, satirical comedy about a young man, Aren, who is recruited into a secret society of magical Black people who dedicate their lives to a cause of utmost importance: making white people’s lives easier.',
        '0',
        'https://m.media-amazon.com/images/M/MV5BYTY5MDQ0ZDItMTU3Ni00ZGZhLWJjODctMjI4NTljZmUwYTZjXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg',
        'https://www.youtube.com/embed/gizIbhk5Eu4?si=q4-elV-32efkF6UT',
        'NR',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'ARGYLLE',
        '11',
        "Henry Cavill, Bryce Dallas Howard, Sam Rockwell, Bryan Cranston, Catherine O'Hara",
        'Matthew Vaughn',
        'Adam Fishbach',
        "Elly Conway, the reclusive author of a series of best-selling espionage novels, whose idea of bliss is a night at home with her computer and her cat, Alfie. But when the plots of Elly's fictional books--which center on secret agent Argylle and his mission to unravel a global spy syndicate--begin to mirror the covert actions of a real-life spy organization, quiet evenings at home become a thing of the past.",
        '0',
        'https://imgur.com/ZnaCoCE.jpeg',
        'https://www.youtube.com/embed/7mgu9mNZ8Hk?si=GJ8b1dM4D3fkl5sE',
        'PG-13',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'ARTHUR THE KING',
        '5',
        'Mark Wahlberg, Nathalie Emmanuel, Juliet Rylance, Simu Liu, Paul Guilfoyle',
        'Simon Cellan Jones',
        'Courtney Solomon',
        'Over the course of ten days and 435 miles, an unbreakable bond is forged between pro adventure racer Michael Light and a scrappy street dog companion dubbed Arthur. Based on an incredible true story, ARTHUR THE KING follows Light, desperate for one last chance to win, as he convinces a sponsor to back him and a team of athletes for the Adventure Racing World Championship in the Dominican Republic.',
        '0',
        'https://imgur.com/7hPiZFc.jpeg',
        'https://www.youtube.com/embed/wjDJNEPghNY?si=aPIfWbCZ2vyt5NPB',
        'PG-13',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'AMERICAN FICTION',
        '4',
        'Jeffrey Wright, Tracee Ellis Ross, Erika Alexander, Issa Rae, Sterling K. Brown',
        'Cord Jefferson',
        'Ben LeClair',
        "Jeffrey Wright stars as Monk, a frustrated novelist who's fed up with the establishment profiting from 'Black' entertainment that relies on tired and offensive tropes. To prove his point, Monk uses a pen name to write an outlandish 'Black' book of his own, a book that propels him to the heart of hypocrisy and the madness he claims to disdain.",
        '0',
        'https://imgur.com/auCtXip.jpeg',
        'https://www.youtube.com/embed/i0MbLCpYJPA?si=ITdS4wshpYfJGUYX',
        'R',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'THE BEEKEEPER',
        '1',
        'Jason Statham, Jeremy Irons, Emmy Raver-Lapman, Bobby Naderi, Josh Hutcherson',
        'David Ayer',
        'Bill Block',
        "In The Beekeeper, one man's brutal campaign for vengeance takes on national stakes after he is revealed to be a former operative of a powerful and clandestine organization known as 'Beekeepers'.",
        '0',
        'https://imgur.com/CxoOTDQ.jpeg',
        'https://www.youtube.com/embed/SzINZZ6iqxY?si=YO1RzCIPH8Qpc9lb',
        'R',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'CABRINI',
        '5',
        "Cristiana Dell'Anna, David Morse, John Lithgow, Giancarlo Giannini, Federico Castelluccio",
        'Alejandro Monteverde',
        'Eduardo Verastegui',
        "Francesca Cabrini, an Italian immigrant who arrives in New York City in 1889 and is greeted by disease, crime, and impoverished children. Cabrini sets off on a daring mission to convince the hostile mayor to secure housing and healthcare for society's most vulnerable. With broken English and poor health, Cabrini uses her entrepreneurial mind to build an empire of hope unlike anything the world had ever seen.",
        '0',
        'https://imgur.com/Dah7F2h.jpeg',
        'https://www.youtube.com/embed/lihCRaOj0Lg?si=-K8CN00r93WH17K3',
        'PG-13',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'CHALLENGERS',
        '5',
        "Zendaya, Josh O'Connor, Mike Faist, A.J. Lister, Amy Pascal",
        'Luca Guadagnino',
        'Kevin Ulrich',
        "Challengers stars Zendaya as Tashi Duncan, a former tennis prodigy turned coach and a force of nature who makes no apologies for her game on and off the court. Married to a champion on a losing streak, Tashi's strategy for her husband's redemption takes a surprising turn when he must face off against the washed-up Patrick -- his former best friend and Tashi's former boyfriend.",
        '0',
        'https://imgur.com/a1PEBx4.jpeg',
        'https://www.youtube.com/embed/MDnVk5jIJr0?si=v5DqwcNYWio1msFg',
        'R',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'DUNE: PART TWO',
        '10',
        'Timothee Chalamet, Zendaya, Rebecca Ferguson, Josh Brolin, Austin Butler',
        'Denis Villeneuve',
        'Denis Villeneuve',
        "'Dune: Part Two' will explore the mythic journey of Paul Atreides as he unites with Chani and the Fremen while on a warpath of revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the known universe, he endeavors to prevent a terrible future only he can foresee.",
        '0',
        'https://imgur.com/vtmeW9N.jpeg',
        'https://www.youtube.com/embed/U2Qp5pL3ovA?si=5ogLkyxYjvKShBus',
        'PG-13',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'LISA FRANKENSTEIN',
        '4',
        'Kathryn Newton, Cole Spouse, Carla Gugino, Liza Soberano, Joe Chrest',
        'Zelda Williams',
        'Diablo Cody',
        'A coming of RAGE love story from acclaimed writer Diablo Cody about a misunderstood teenager and her high school crush, who happens to be a handsome corpse. After a set of playfully horrific circumstances bring him back to life, the two embark on a murderous journey to find love, happiness... and a few missing body parts along the way.',
        '0',
        'https://imgur.com/Wc02dPb.jpeg',
        'https://www.youtube.com/embed/POOeA3zCuUY?si=WWR407zdrZpliR6v',
        'PG-13',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'FURIOSA: A MAD MAX STORY',
        '1',
        'Anya Taylor-Joy, Chris Hemsworth, Alyla Browne, Tom Burke, Nathan Jones',
        'George Miller',
        'Doug Mitchell',
        'As the world fell, young Furiosa is snatched from the Green Place of Many Mothers and falls into the hands of a great Biker Horde led by the Warlord Dementus. Sweeping through the Wasteland, they come across the Citadel presided over by The Immortan Joe. While the two Tyrants war for dominance, Furiosa must survive many trials as she puts together the means to find her way home.',
        '0',
        'https://imgur.com/C78tgY4.jpeg',
        'https://www.youtube.com/embed/XJMuhwVlca4?si=3O-94ht2vavVOaUh',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'THE GARFIELD MOVIE',
        '3',
        'Chris Pratt, Samuel L. Jackson, Nicholas Hoult, Hannah Waddingham, Cecily Strong',
        'Mark Dindal',
        'Bridget McMeel',
        "Garfield, the world-famous, Monday-hating, lasagna-loving indoor cat, is about to have a wild outdoor adventure! After an unexpected reunion with his long-lost father - scruffy street cat Vic - Garfield and his canine friend Odie are forced from their perfectly pampered life into joining Vic in a hilarious, high-stakes heist.",
        '0',
        'https://imgur.com/81807a6.jpeg',
        'https://www.youtube.com/embed/IeFWNtMo1Fs?si=XB448pHGSbm3ZDGX',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'GHOSTBUSTERS: FROZEN EMPIRE',
        '2',
        'Paul Rudd, Carrie Coon, Finn Wolfhard, Mckenna Grace, Kumail Nanjiani',
        'Gil Kenan',
        'Gil Kenan',
        "The Spengler family returns to where it all started - the iconic New York City firehouse - to team up with the original Ghostbusters, who've developed a top-secret research lab to take busting ghosts to the next level. But when the discovery of an ancient artifact unleashes an evil force, Ghostbusters new and old must join forces to protect their home and save the world from a second Ice Age.",
        '0',
        'https://imgur.com/aIXthyW.jpeg',
        'https://www.youtube.com/embed/6hjlyknlTaw?si=xSvNw4vym3cGerCN',
        'PG-13',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'GODZILLA X KONG: THE NEW EMPIRE',
        '1',
        'Rebecca Hall, Brian Tyree Henry, Dan Stevens, Kaylee Hottle, Alex Ferns',
        'Adam Wingard',
        'Alex Garcia',
        "The epic battle continues! Legendary Pictures' cinematic Monsterverse follows up the explosive showdown of 'Godzilla vs. Kong' with an all-new adventure that pits the almighty Kong and the fearsome Godzilla against a colossal undiscovered threat hidden within our world, challenging their very existence-and our own.",
        '0',
        'https://imgur.com/0d5LDrc.jpeg',
        'https://www.youtube.com/embed/lV1OOlGwExM?si=szBLZ7fMo4dv8K5A',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'IF',
        '4',
        'Emily Blunt, Ryan Reynolds, Matt Damon, Pheobe Waller-Bridge, Steve Carell',
        'John Krasinski',
        'John Krasinksi',
        "From writer and director John Krasinski, IF is about a girl who discovers that she can see everyone's imaginary friends - and what she does with that superpower - as she embarks on a magical adventure to reconnect forgotten IFs with their kids.",
        '0',
        'https://imgur.com/n5AUynu.jpeg',
        'https://www.youtube.com/embed/ss2KvK-w6w8?si=IsAhgl92GJD9UCaq',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'IMAGINARY',
        '8',
        'Betty Buckley, Veronica Falcon, Matthew Sato, Diane DiLiegro, Suzette Lange',
        'Jeff Wadlow',
        'Jason Blum',
        "An original horror film that taps into the innocence of imaginary friends - and begs the question: Are they really figments of childhood imagination or is something more terrifying lying just beneath?",
        '0',
        'https://imgur.com/HhQzHrM.jpeg',
        'https://www.youtube.com/embed/8XoNfrgrAGM?si=e5Cueu_I37qiC-mD',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'INSIDE OUT 2',
        '3',
        'Maya Hawke, Amy Poehler, Phyllis Smith, Lewis Black, Tony Hale',
        'Kelsey Mann',
        'Mark Nielsen',
        "Joy, Sadness, Anger, Fear and Disgust have been running a successful operation by all accounts. However, when Anxiety shows up, they aren't sure how to feel.",
        '0',
        'https://imgur.com/5qE8v13.jpeg',
        'https://www.youtube.com/embed/ogA-kyjQLhU?si=E_pnExHzsg_JdAJ0',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'KUNG FU PANDA 4',
        '3',
        'Jack Black, Awkwafina, Viola Davis, Dustin Hoffman, James Hong',
        'Mike Mitchell',
        'Rebecca Huntley',
        "After three death-defying adventures defeating world-class villains with his unmatched courage and mad martial arts skills, Po, the Dragon Warrior, is called upon by destiny to... give it a rest already. More specifically, he's tapped to become the Spiritual Leader of the Valley of Peace.",
        '0',
        'https://imgur.com/obfZ11D.jpeg',
        'https://www.youtube.com/embed/_inKs4eeHiI?si=hiQSxzMzpB7PeyKc',
        'PG',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'LAND OF BAD',
        '5',
        'Liam Hemsworth, Russel Crowe, Luke Hemsworth, Ricky Whittle, Milo Ventimiglia',
        'William Eubank',
        'Adam Beasley',
        "A covert Special Forces operation in the South Philippines spirals into a brutal 48-hour battle for survival. When an elite extraction team is ambushed deep in enemy territory, rookie officer Kinney is left outnumbered but determined to leave no man behind.",
        '0',
        'https://imgur.com/sVpP1iT.jpeg',
        'https://www.youtube.com/embed/yTFazxfrXVw?si=wZLxCaDR0_o5fGPD',
        'R',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'MADAME WEB',
        '12',
        "Dakota Johnson, Sydney Sweeney, Celeste O'Connor, Isabela Merced, Tahar Rahim",
        'S.J. Clarkson',
        'Adam Merims',
        "In a switch from the typical genre, Madame Web tells the standalone origin story of one of Marvel publishing's most enigmatic heroines. The suspense-driven thriller stars Dakota Johnson as Cassandra Webb, a paramedic in Manhattan who develops the power to see the future... and realizes she can use that insight to change it.",
        '0',
        'https://imgur.com/QDi5BpA.jpeg',
        'https://www.youtube.com/embed/s_76M4c4LTo?si=keDPlyBxYmRaysXE',
        'PG-13',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'BOB MARLEY: ONE LOVE',
        '5',
        'Kingsley Ben-Adir, Lashana Lynch, James Norton, Tosin Cole, Umi Myers',
        'Reinaldo Marcus Green',
        'Reinaldo Marcus Green',
        "BOB MARLEY: ONE LOVE celebrates the life and music of an icon who inspired generations through his message of love and unity. On the big screen for the first time, discover Bob's powerful story of overcoming adversity and the journey behind his revolutionary music.",
        '0',
        'https://imgur.com/z1xmH4d.jpeg',
        'https://www.youtube.com/embed/ajw425Kuvtw?si=hbbjXfiVyyvBezD8',
        'PG-13',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'MEAN GIRLS',
        '6',
        "Angourie Rice, Renee Rapp, Auli'i Cravalho, Jaquel Spivey, Avantika",
        'Samantha Jayne',
        'Samantha Jayne',
        "From the comedic mind of Tina Fey comes a new twist on the modern classic, MEAN GIRLS. New student Cady Heron is welcomed into the top of the social food chain by the elite group of popular girls called 'The Plastics,' ruled by the conniving queen bee Regina George and her minions Gretchen and Karen.",
        '0',
        'https://imgur.com/rrsI6rO.jpeg',
        'https://www.youtube.com/embed/fFtdbEgnUOk?si=4yGKj7amYuz3GEyZ',
        'PG-13',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'MICKEY 17',
        '10',
        'Robert Pattinson, Mark Ruffalo, Toni Collette, Naomi Ackie, Steven Yeun',
        'Bong Joon Ho',
        'Bong Joon Ho',
        'To stop his substitute clone Mickey8 from supplanting him, Mickey7, an expendable robot, is dispatched to an icy planet to settle it.',
        '0',
        'https://imgur.com/ruGfOOr.jpeg',
        'https://www.youtube.com/embed/26uTcwSriMg?si=ffxjXNc3zatOnU6A',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'NIGHT SHIFT',
        '8',
        'Pheobe Tonkin, Madison Hu, Lamorne Morris, Patrick Fischler, Christopher Denham',
        'Benjamin China, Paul China',
        'Bradley Pilz',
        "While working her first night shift at a remote motel, a young woman, Gwen Taylor, begins to suspect that she is being followed by a dangerous character from her past. As the night progresses, Gwen's isolation and safety, however, are made all the more worse when she starts to realize that the motel might also be haunted.",
        '0',
        'https://imgur.com/aWPsJV0.jpeg',
        'https://www.youtube.com/embed/As0fOZt59bI?si=rq6varfdbEFyTpQu',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'OPPENHEIMER',
        '5',
        'Cillian Murphy, Emily Blunt, Robert Downey Jr., Matt Damon, FLorence Pugh',
        'Christopher Nolan',
        'Christopher Nolan',
        'Written and directed by Christopher Nolan, Oppenheimer is an IMAX-shot epic thriller that thrusts audiences into the pulse-pounding paradox of the enigmatic man who must risk destroying the world in order to save it.',
        '0',
        'https://imgur.com/GklmZC3.jpeg',
        'https://www.youtube.com/embed/uYPbbksJxIg?si=S2mATEhTdztm-OVa',
        'R',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'ORDINARY ANGLES',
        '5',
        'Hilary Swank, Alan Ritchson, Nancy Travis, Amy Acker, Tamala Jones',
        'Jon Gunn',
        'Andrew Erwin',
        'Based on a remarkable true story, ORDINARY ANGELS centers on Sharon Steves, a fierce but struggling hairdresser in small-town Kentucky who discovers a renewed sense of purpose when she meets Ed Schmitt, a widower working hard to make ends meet for his two daughters.',
        '0',
        'https://imgur.com/71wDaSu.jpeg',
        'https://www.youtube.com/embed/R1vn8kPgCYA?si=I9imOlrbPXiay_tP',
        'PG',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'OUT OF DARKNESS',
        '5',
        'Safia Oakley-Green, Kit Young, Chuku Modu, Iola Evans, Arno Luening',
        'Andrew Cumming',
        'David Kaplan',
        "A group of six have struggled across the narrow sea to find a new home. They are starving, desperate, and living 45,000 years ago. First they must find shelter, and they strike out across the tundra wastes towards the distant mountains that promise the abundant caves they need to survive. But when night falls, anticipation turns to fear and doubt as they realize they are not alone.",
        '0',
        'https://imgur.com/1VWXL5O.jpeg',
        'https://www.youtube.com/embed/sU_SQo1wbos?si=j-oCTrVMko5agDRU',
        'R',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'KINGDOM OF THE PLANET OF THE APES',
        '10',
        'Owen Teague, Freya Allan, Kevin Durand, William H. Macy, Peter Macon',
        'Wes Ball',
        'Amanda Silver',
        'As a new tyrannical ape leader builds his empire, one young ape undertakes a harrowing journey that will cause him to question all that he has known about the past and to make choices that will define a future for apes and humans alike.',
        '0',
        'https://imgur.com/PV74hcd.jpeg',
        'https://www.youtube.com/embed/XtFI7SNtVpY?si=CInHBR9OyUT92Pcc',
        'NR',
        'coming soon'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'POOR THINGS',
        '5',
        'Emma Stone, Willem Dafoe, Mark Ruffalo, Christopher Abott, Jerrod Carmichael',
        'Yorgos Lanthimos',
        'Emma Stone',
        "Bella Baxter, a young woman brought back to life by the brilliant and unorthodox scientist Dr. Godwin Baxter. Under Baxter's protection, Bella is eager to learn. Hungry for the worldliness she is lacking, Bella runs off with Duncan Wedderburn, a slick and debauched lawyer, on a whirlwind adventure across the continents.",
        '0',
        'https://imgur.com/8w7xmsI.jpeg',
        'https://www.youtube.com/embed/RlbR5N6veqw?si=ZHTLPgYcpNilq6ne',
        'R',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'A QUIET PLACE: DAY ONE',
        '8',
        "Lupita Nyong'o, Albert McCausland, Allyson Seeger, Andrew Form, Andrew Mondshein",
        'Michael Sarnoski',
        'John Krasinski',
        'Experience the day the world went quiet.',
        '0',
        'https://imgur.com/BoPWB3z.jpeg',
        'https://www.youtube.com/embed/YPY7J-flzE8?si=8R6RRup891kbHlu1',
        'NR',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'WICKED',
        '6',
        'Ariana Grande, Cynthia Erivo, Jeff Goldblum, Michelle Yeoh, Jonathan Bailey',
        'John M. Chu',
        'David Stone',
        "Wicked, the untold story of the witches of Oz, stars Emmy, Grammy and Tony winning powerhouse Cynthia Erivo as Elphaba, a young woman, misunderstood because of her unusual green skin, who has yet to discover her true power, and Ariana Grande as Glinda, a popular young woman, gilded by privilege and ambition, who has yet to discover her true heart.",
        '0',
        'https://imgur.com/a75ZgXR.jpeg',
        'https://www.youtube.com/embed/F1dvX9Vs0ns?si=zhIQ4lSnhD9pJ8Jt',
        'NR',
        'now playing'
    );
INSERT INTO movies(
        movie_title,
        category_id,
        cast,
        director,
        producer,
        synopsis,
        reviews,
        picture,
        video,
        rating_code,
        movie_status
    )
VALUES (
        'WONKA',
        '7',
        'Timothee Chalamet, Hugh Grant, Calah Lane, Keegan-Michael Key, Patterson Joseph',
        'Paul King',
        'Paul King',
        "Based on the extraordinary character at the center of Charlie and the Chocolate Factory, Roald Dahl's most iconic children's book and one of the best-selling children's books of all time, 'Wonka' tells the wondrous story of how the world's greatest inventor, magician and chocolate-maker became the beloved Willy Wonka we know today.",
        '0',
        'https://imgur.com/z4gTXRJ.jpeg',
        'https://www.youtube.com/embed/otNh9bTjXWg?si=AZAXZ31cZTkl3Hfn',
        'PG',
        'coming soon'
    );