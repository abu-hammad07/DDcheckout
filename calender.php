<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar Events</title>
    <script src="https://apis.google.com/js/api.js"></script>
</head>

<body>

    <h1>Google Calender</h1>


    <button id="authorize_button" style="display: none;">Authorize</button>
    <button id="signout_button" style="display: none;">Sign Out</button>
    <div id="calendar"></div>
    <script>
        const CLIENT_ID = "73625581170-7tp76nsjshd01fj24a8mr3pqkd96c422.apps.googleusercontent.com";
        const API_KEY = "AIzaSyDFjgZ-IKf_wAISG7i2TIjNgX6bjsXVdzc";
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

        // Load the client on page load
        document.addEventListener("DOMContentLoaded", handleClientLoad);
    </script>
</body>

</html> -->






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar Events</title>
    <script src="https://apis.google.com/js/api.js"></script>
</head>

<body>
    <h1>Google Calendar</h1>

    <!-- Buttons for authentication -->
    <button id="authorize_button" style="display: none;">Authorize</button>
    <button id="signout_button" style="display: none;">Sign Out</button>

    <!-- Div for displaying calendar events -->
    <h2>Upcoming Events:</h2>
    <div id="calendar">
        <p>Loading events...</p>
    </div>

    <script>
        const CLIENT_ID = "73625581170-7tp76nsjshd01fj24a8mr3pqkd96c422.apps.googleusercontent.com";
        const API_KEY = "AIzaSyDFjgZ-IKf_wAISG7i2TIjNgX6bjsXVdzc";
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
                    document.getElementById("calendar").innerHTML = "<p>Error loading Google Calendar API.</p>";
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
                document.getElementById("calendar").innerHTML = "<p>Please authorize to view events.</p>";
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
                    calendarDiv.innerHTML = ""; // Clear previous content

                    if (events.length > 0) {
                        events.forEach((event) => {
                            const eventElement = document.createElement("div");
                            eventElement.style.border = "1px solid #ccc";
                            eventElement.style.margin = "10px 0";
                            eventElement.style.padding = "10px";
                            eventElement.style.borderRadius = "5px";

                            const start = event.start.dateTime || event.start.date;
                            eventElement.innerHTML = `
                                <strong>${event.summary || "No Title"}</strong><br>
                                <small><strong>Start:</strong> ${new Date(start).toLocaleString()}</small><br>
                                ${event.description ? `<p>${event.description}</p>` : ""}
                            `;
                            calendarDiv.appendChild(eventElement);
                        });
                    } else {
                        calendarDiv.innerHTML = "<p>No upcoming events found.</p>";
                    }
                })
                .catch((error) => {
                    console.error("Error fetching events:", error);
                    document.getElementById("calendar").innerHTML = "<p>Unable to load events.</p>";
                });
        }

        document.addEventListener("DOMContentLoaded", handleClientLoad);
    </script>
</body>

</html>
