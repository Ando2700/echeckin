CREATE TABLE public.attendees (
    id bigint NOT NULL,
    firstname character varying(255) NOT NULL,
    lastname character varying(255) NOT NULL,
    email character varying(255) NOT NULL
);


ALTER TABLE public.attendees OWNER TO postgres;


CREATE SEQUENCE public.attendees_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attendees_id_seq OWNER TO postgres;


ALTER SEQUENCE public.attendees_id_seq OWNED BY public.attendees.id;

CREATE TABLE public.eventdetails (
    id bigint NOT NULL,
    additional_information text,
    event_id bigint NOT NULL
);


ALTER TABLE public.eventdetails OWNER TO postgres;


CREATE SEQUENCE public.eventdetails_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.eventdetails_id_seq OWNER TO postgres;

ALTER SEQUENCE public.eventdetails_id_seq OWNED BY public.eventdetails.id;


CREATE TABLE public.events (
    id bigint NOT NULL,
    eventname character varying(255) NOT NULL,
    datedebut timestamp(0) without time zone NOT NULL,
    datefin timestamp(0) without time zone NOT NULL,
    description text NOT NULL,
    place_id bigint NOT NULL,
    eventtype_id bigint NOT NULL
);


ALTER TABLE public.events OWNER TO postgres;

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.events_id_seq OWNER TO postgres;


ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


CREATE TABLE public.eventtypes (
    id bigint NOT NULL,
    eventtype character varying(255) NOT NULL
);


ALTER TABLE public.eventtypes OWNER TO postgres;

CREATE SEQUENCE public.eventtypes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.eventtypes_id_seq OWNER TO postgres;

ALTER SEQUENCE public.eventtypes_id_seq OWNED BY public.eventtypes.id;


CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;


CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;


ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;

CREATE TABLE public.images (
    id bigint NOT NULL,
    path character varying(255) NOT NULL,
    place_id bigint NOT NULL
);


ALTER TABLE public.images OWNER TO postgres;


CREATE SEQUENCE public.images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.images_id_seq OWNER TO postgres;


ALTER SEQUENCE public.images_id_seq OWNED BY public.images.id;


CREATE TABLE public.invitations (
    id bigint NOT NULL,
    event_id bigint NOT NULL,
    attendee_id bigint NOT NULL,
    qr_code character varying(255) NOT NULL,
    status smallint DEFAULT '0'::smallint NOT NULL
);


ALTER TABLE public.invitations OWNER TO postgres;

CREATE SEQUENCE public.invitations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.invitations_id_seq OWNER TO postgres;

ALTER SEQUENCE public.invitations_id_seq OWNED BY public.invitations.id;

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;


CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;


ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;


CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


CREATE TABLE public.places (
    id bigint NOT NULL,
    nomplace character varying(255) NOT NULL,
    numberplace integer DEFAULT 0 NOT NULL,
    description text,
    price numeric(12,2),
    address character varying(255)
);


ALTER TABLE public.places OWNER TO postgres;

CREATE SEQUENCE public.places_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.places_id_seq OWNER TO postgres;


ALTER SEQUENCE public.places_id_seq OWNED BY public.places.id;

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;


CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;


ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


CREATE VIEW public.v_event AS
 SELECT e.id,
    e.eventname,
    e.datedebut,
    e.datefin,
    e.description,
    p.nomplace,
    et.eventtype
   FROM ((public.events e
     JOIN public.places p ON ((e.place_id = p.id)))
     JOIN public.eventtypes et ON ((e.eventtype_id = et.id)));


ALTER TABLE public.v_event OWNER TO postgres;

ALTER TABLE ONLY public.attendees ALTER COLUMN id SET DEFAULT nextval('public.attendees_id_seq'::regclass);

ALTER TABLE ONLY public.eventdetails ALTER COLUMN id SET DEFAULT nextval('public.eventdetails_id_seq'::regclass);


ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


ALTER TABLE ONLY public.eventtypes ALTER COLUMN id SET DEFAULT nextval('public.eventtypes_id_seq'::regclass);

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);

ALTER TABLE ONLY public.images ALTER COLUMN id SET DEFAULT nextval('public.images_id_seq'::regclass);

ALTER TABLE ONLY public.invitations ALTER COLUMN id SET DEFAULT nextval('public.invitations_id_seq'::regclass);


ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


ALTER TABLE ONLY public.places ALTER COLUMN id SET DEFAULT nextval('public.places_id_seq'::regclass);


ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


ALTER TABLE ONLY public.attendees
    ADD CONSTRAINT attendees_pkey PRIMARY KEY (id);

ALTER TABLE ONLY public.eventdetails
    ADD CONSTRAINT eventdetails_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);

ALTER TABLE ONLY public.eventtypes
    ADD CONSTRAINT eventtypes_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


ALTER TABLE ONLY public.images
    ADD CONSTRAINT images_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);

ALTER TABLE ONLY public.places
    ADD CONSTRAINT places_pkey PRIMARY KEY (id);


ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);



CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);

ALTER TABLE ONLY public.eventdetails
    ADD CONSTRAINT eventdetails_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_eventtype_id_foreign FOREIGN KEY (eventtype_id) REFERENCES public.eventtypes(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_place_id_foreign FOREIGN KEY (place_id) REFERENCES public.places(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.images
    ADD CONSTRAINT images_place_id_foreign FOREIGN KEY (place_id) REFERENCES public.places(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_attendee_id_foreign FOREIGN KEY (attendee_id) REFERENCES public.attendees(id) ON DELETE CASCADE;


ALTER TABLE ONLY public.invitations
    ADD CONSTRAINT invitations_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
