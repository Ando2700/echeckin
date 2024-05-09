-- SEQUENCES
CREATE SEQUENCE users_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE failed_jobs_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE migrations_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE personal_access_tokens_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE attendees_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE eventdetails_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE events_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE eventtypes_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE images_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE invitations_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE places_id_seq START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE presences_id_seq START WITH 1 INCREMENT BY 1;

-- USERS 
CREATE  TABLE users ( 
	id                   bigint DEFAULT nextval('users_id_seq'::regclass) NOT NULL  ,
	name                 varchar(255)  NOT NULL  ,
	email                varchar(255)  NOT NULL  ,
	email_verified_at    TIMESTAMP    ,
	"password"           varchar(255)  NOT NULL  ,
	remember_token       varchar(100)    ,
	created_at           TIMESTAMP    ,
	updated_at           TIMESTAMP    ,
	CONSTRAINT users_pkey PRIMARY KEY ( id ),
	CONSTRAINT users_email_unique UNIQUE ( email ) 
);

-- FAILED_JOBS
CREATE  TABLE failed_jobs ( 
	id                   bigint DEFAULT nextval('failed_jobs_id_seq'::regclass) NOT NULL  ,
	uuid                 varchar(255)  NOT NULL  ,
	"connection"         text  NOT NULL  ,
	queue                text  NOT NULL  ,
	payload              text  NOT NULL  ,
	"exception"          text  NOT NULL  ,
	failed_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL  ,
	CONSTRAINT failed_jobs_pkey PRIMARY KEY ( id ),
	CONSTRAINT failed_jobs_uuid_unique UNIQUE ( uuid ) 
 );

-- MIGRATIONS
CREATE  TABLE migrations ( 
	id                   integer DEFAULT nextval('migrations_id_seq'::regclass) NOT NULL  ,
	migration            varchar(255)  NOT NULL  ,
	batch                integer  NOT NULL  ,
	CONSTRAINT migrations_pkey PRIMARY KEY ( id )
 );

-- PERSONNAL_ACCESS_TOKENS
CREATE  TABLE personal_access_tokens ( 
	id                   bigint DEFAULT nextval('personal_access_tokens_id_seq'::regclass) NOT NULL  ,
	tokenable_type       varchar(255)  NOT NULL  ,
	tokenable_id         bigint  NOT NULL  ,
	name                 varchar(255)  NOT NULL  ,
	token                varchar(64)  NOT NULL  ,
	abilities            text    ,
	last_used_at         TIMESTAMP    ,
	expires_at           TIMESTAMP    ,
	created_at           TIMESTAMP    ,
	updated_at           TIMESTAMP    ,
	CONSTRAINT personal_access_tokens_pkey PRIMARY KEY ( id ),
	CONSTRAINT personal_access_tokens_token_unique UNIQUE ( token ) 
 );

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON personal_access_tokens  ( tokenable_type, tokenable_id );

-- PASSWORD_RESET_TOKENS
CREATE  TABLE password_reset_tokens ( 
	email                varchar(255)  NOT NULL  ,
	token                varchar(255)  NOT NULL  ,
	created_at           TIMESTAMP    ,
	CONSTRAINT password_reset_tokens_pkey PRIMARY KEY ( email )
 );

-- PASSWORD_RESETS
CREATE  TABLE password_resets ( 
	email                varchar(255)  NOT NULL  ,
	token                varchar(255)  NOT NULL  ,
	created_at           TIMESTAMP    
 );

CREATE INDEX password_resets_email_index ON password_resets  ( email );


-- EVENTTYPES
CREATE TABLE eventtypes (
    id bigint DEFAULT nextval('eventtypes_id_seq' :: regclass) NOT NULL,
    eventtype varchar(255) NOT NULL,
    CONSTRAINT eventtypes_pkey PRIMARY KEY (id)
);

-- ATTENDEES
CREATE TABLE attendees (
    id bigint DEFAULT nextval('attendees_id_seq' :: regclass) NOT NULL,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    CONSTRAINT attendees_pkey PRIMARY KEY (id)
);
INSERT INTO
    attendees (firstname, lastname, email)
VALUES
    ('Ando', 'Mahefa', 'andomahefa534@gmail.com'),
    ('Capone', 'Bege', 'caponebege534@gmail.com'),
    ('Diamondra', 'Nomeniavo','diamondrarabe19@gmail.com');

-- PLACES
CREATE TABLE places (
    id bigint DEFAULT nextval('places_id_seq' :: regclass) NOT NULL,
    nomplace varchar(255) NOT NULL,
    numberplace integer DEFAULT 0 NOT NULL,
    description text,
    price numeric(12, 2),
    address varchar(255),
    CONSTRAINT places_pkey PRIMARY KEY (id)
);

-- IMAGES
CREATE TABLE images (
    id bigint DEFAULT nextval('images_id_seq' :: regclass) NOT NULL,
    "path" varchar(255) NOT NULL,
    place_id bigint NOT NULL,
    CONSTRAINT images_pkey PRIMARY KEY (id)
);

ALTER TABLE
    images
ADD
    CONSTRAINT images_place_id_foreign FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE;

-- EVENTS
CREATE TABLE events (
    id bigint DEFAULT nextval('events_id_seq' :: regclass) NOT NULL,
    eventname varchar(255) NOT NULL,
    datedebut TIMESTAMP NOT NULL,
    datefin TIMESTAMP NOT NULL,
    description text NOT NULL,
    place_id bigint NOT NULL,
    eventtype_id bigint NOT NULL,
    CONSTRAINT events_pkey PRIMARY KEY (id)
);

ALTER TABLE
    events
ADD
    CONSTRAINT events_eventtype_id_foreign FOREIGN KEY (eventtype_id) REFERENCES eventtypes(id) ON DELETE CASCADE;

ALTER TABLE
    events
ADD
    CONSTRAINT events_place_id_foreign FOREIGN KEY (place_id) REFERENCES places(id) ON DELETE CASCADE;

-- INVITATIONS
CREATE TABLE invitations (
    id bigint DEFAULT nextval('invitations_id_seq' :: regclass) NOT NULL,
    event_id bigint NOT NULL,
    attendee_id bigint NOT NULL,
    qr_code varchar(255) NOT NULL,
    reference varchar(255) NOT NULL,
    status smallint DEFAULT '0' :: smallint NOT NULL,
    CONSTRAINT invitations_pkey PRIMARY KEY (id)
);

ALTER TABLE
    invitations
ADD
    CONSTRAINT invitations_attendee_id_foreign FOREIGN KEY (attendee_id) REFERENCES attendees(id) ON DELETE CASCADE;

ALTER TABLE
    invitations
ADD
    CONSTRAINT invitations_event_id_foreign FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE;

-- EVENTDETAILS
CREATE TABLE eventdetails (
    id bigint DEFAULT nextval('eventdetails_id_seq' :: regclass) NOT NULL,
    additional_information text,
    event_id bigint NOT NULL,
    CONSTRAINT eventdetails_pkey PRIMARY KEY (id)
);

ALTER TABLE
    eventdetails
ADD
    CONSTRAINT eventdetails_event_id_foreign FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE;

-- PRESENCES
CREATE TABLE presences (
    id bigint DEFAULT nextval('presences_id_seq' :: regclass) NOT NULL,
    reference VARCHAR(255) NOT NULL,
    date_heure_presence TIMESTAMP NOT NULL,
    CONSTRAINT presences_pkey PRIMARY KEY (id)
);
ALTER TABLE presences
ADD COLUMN event_id bigint NOT NULL,
ADD COLUMN attendee_id bigint NOT NULL,
ADD CONSTRAINT presences_event_id_foreign FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
ADD CONSTRAINT presences_attendee_id_foreign FOREIGN KEY (attendee_id) REFERENCES attendees(id) ON DELETE CASCADE;