// const CLIENT_ID = "73625581170-7tp76nsjshd01fj24a8mr3pqkd96c422.apps.googleusercontent.com";
// const API_KEY = "AIzaSyDFjgZ-IKf_wAISG7i2TIjNgX6bjsXVdzc";
const CLIENT_ID = "223958138395-uhgl6jdo4j9hfcillpp8fl3nnub2fmh4.apps.googleusercontent.com";
const API_KEY = "AIzaSyCiLCSEqkcmRFWvjErNRmt1jql11-2iOYI";
const DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];
const SCOPES = "https://www.googleapis.com/auth/calendar.readonly";

function handleClientLoad() {
  gapi.load("client:auth2", initClient);
}

function initClient() {
  gapi.client
    .init({
      apiKey: API_KEY,
      clientId: CLIENT_ID,
      discoveryDocs: DISCOVERY_DOCS,
      scope: SCOPES,
    })
    .then(() => {
      const authInstance = gapi.auth2.getAuthInstance();
      authInstance.isSignedIn.listen(updateSigninStatus);
      updateSigninStatus(authInstance.isSignedIn.get());
      document.getElementById("authorize_button").onclick = handleAuthClick;
      document.getElementById("signout_button").onclick = handleSignoutClick;
    })
    .catch((error) => {
      console.error("Error initializing Google API client:", error);
    });
}

function updateSigninStatus(isSignedIn) {
  if (isSignedIn) {
    document.getElementById("authorize_button").style.display = "none";
    document.getElementById("signout_button").style.display = "block";
    listUpcomingEvents();
  } else {
    document.getElementById("authorize_button").style.display = "block";
    document.getElementById("signout_button").style.display = "none";
  }
}

function handleAuthClick() {
  gapi.auth2.getAuthInstance().signIn().catch((error) => {
    console.error("Error during sign-in:", error);
  });
}

function handleSignoutClick() {
  gapi.auth2.getAuthInstance().signOut().catch((error) => {
    console.error("Error during sign-out:", error);
  });
}

function listUpcomingEvents() {
  gapi.client.calendar.events
    .list({
      calendarId: "primary",
      timeMin: new Date().toISOString(),
      showDeleted: false,
      singleEvents: true,
      maxResults: 10,
      orderBy: "startTime",
    })
    .then((response) => {
      const events = response.result.items;
      const calendarDiv = document.getElementById("calendar");
      calendarDiv.innerHTML = "";

      if (events.length > 0) {
        events.forEach((event) => {
          const eventElement = document.createElement("div");
          const start = event.start.dateTime || event.start.date;
          eventElement.textContent = `${start} - ${event.summary}`;
          calendarDiv.appendChild(eventElement);
        });
      } else {
        calendarDiv.textContent = "No upcoming events found.";
      }
    })
    .catch((error) => {
      console.error("Error fetching events:", error);
      document.getElementById("calendar").textContent =
        "Unable to load events.";
    });
}

document.addEventListener("DOMContentLoaded", handleClientLoad);
