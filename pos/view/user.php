<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Enrollment System</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: url('1.png') no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    padding: 0;
  }
  header {
    background-color: rgba(30, 58, 138, 0.85);
    color: white;
    padding: 1rem;
    text-align: center;
  }
  nav {
    display: flex;
    justify-content: center;
    background: #1e3a8a;
  }
  nav a {
    color: white;
    padding: 1rem;
    text-decoration: none;
    transition: background 0.3s;
  }
  nav a:hover {
    background: #2563eb;
  }
  main {
    max-width: 800px;
    margin: auto;
    background: rgba(255, 255, 255, 0.9);
    padding: 1rem 2rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 10px;
    margin-top: 1rem;
    position: relative;
  }
  h2 {
    color: #1e3a8a;
    border-bottom: 2px solid #1e3a8a;
    padding-bottom: 5px;
  }
  label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
  }
  select, button, input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  .course-list { margin-top: 10px; }
  .course { margin: 5px 0; }
  .hidden { display: none; }
  button {
    background: #1e3a8a;
    color: white;
    border: none;
    margin-top: 10px;
  }
  button:hover {
    background: #2563eb;
  }
</style>
</head>
<body>

<header>
  <h1>Student Enrollment System</h1>
</header>

<!-- Navigation -->
<nav>
  <a href="#" onclick="showSection('home')">Home</a>
  <a href="#" onclick="showSection('about')">About</a>
  <a href="#" onclick="showSection('enrollment')">Enrollment Form</a>
  <a href="#" onclick="showSection('payment')">Payment Method</a>
</nav>

<!-- Main Content -->
<main>
  <!-- Home -->
  <section id="home">
    <h2>Welcome</h2>
    <p>Welcome to the Student Enrollment System. Please navigate through the menu to learn more about our system, register for courses, or complete payments.</p>
  </section>

  <!-- About -->
  <section id="about" class="hidden">
    <h2>About</h2>
    <p>This system is designed to make student enrollment easier. You can fill up your details, choose your course and section, and process your payment online.</p>
  </section>

  <!-- Enrollment Form -->
  <section id="enrollment" class="hidden">
    <h2>Enrollment Form</h2>
  <form id="enrollmentForm" method="POST">
      <label for="studentName">Student Name</label>
      <input type="text" id="studentName" name="studentName" placeholder="Enter your name">

      <label for="yearLevel">Year Level</label>
      <select id="yearLevel" name="yearLevel">
        <option value="">-- Select Year Level --</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
      </select>

      <label for="courses">Available Courses</label>
      <div id="courseList" class="course-list"></div>

      <label for="section">Section</label>
      <select id="section" name="section">
        <option value="">-- Select Section --</option>
      </select>

      <button type="button" id="reviewBtn">Review Enrollment</button>
    </form>
  </section>


<!-- Payment Section -->
<section id="payment" class="hidden">
  <h2>Payment Method</h2>
  <p>Please confirm your enrollment by selecting a payment method below:</p>

  <!-- Show enrollment info -->
  <div id="enrollmentSummary" style="background:#f3f4f6; padding:10px; border-radius:8px; margin-bottom:15px;">
  <h3>Enrollment Summary</h3>
  <p><strong>Name:</strong> <span id="summaryName"></span></p>
  <p><strong>Year Level:</strong> <span id="summaryYear"></span></p>
  <p><strong>Course:</strong> <span id="summaryCourse"></span></p>
  <p><strong>Section:</strong> <span id="summarySection"></span></p>
</div>


  <!-- Payment options -->
  <label for="paymentMethod">Select Payment Method</label>
  <select id="paymentMethod" name="paymentMethod" form="enrollmentForm">
    <option value="">-- Select Payment Method --</option>
    <option value="cash">Cash (at School Cashier)</option>
    <option value="gcash">GCash (0917-123-4567)</option>
  </select>

  <button id="finalizeBtn">Finalize Enrollment</button>
</section>



<script>
// Show section
function showSection(sectionId) {
  document.querySelectorAll("main section").forEach(sec => {
    sec.classList.add("hidden");
  });
  document.getElementById(sectionId).classList.remove("hidden");
}

// Enrollment data object
let enrollmentData = {};

// Enrollment Review → go to payment
document.addEventListener("DOMContentLoaded", () => {
  const saved = sessionStorage.getItem("enrollmentData");
  if (saved) {
    const { name, year, section, course } = JSON.parse(saved);
    document.getElementById("summaryName").textContent = name;
    document.getElementById("summaryYear").textContent = year;
    document.getElementById("summarySection").textContent = section;
    document.getElementById("summaryCourse").textContent = course;
  }
});

// Finalize with payment
document.getElementById("finalizeBtn").addEventListener("click", () => {
  const paymentMethod = document.getElementById("paymentMethod").value;

  if (!paymentMethod) {
    Swal.fire({
      icon: 'warning',
      title: 'No Payment Selected',
      text: 'Please select a payment method.'
    });
    return;
  }

  Swal.fire({
    title: "Confirm Payment",
    text: "Are you sure you want to finalize your enrollment with this payment method?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Yes, Submit"
  }).then(res => {
    if (res.isConfirmed) {
      // Show dynamic waiting modal
      Swal.fire({
        title: 'Waiting for Payment Approval...',
        html: 'Please wait while we confirm your payment.',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // ⏳ Simulate dynamic update (e.g., server check)
      setTimeout(() => {
        Swal.update({
          title: 'Payment Approved ✅',
          html: 'Your enrollment has been successfully finalized!'
        });

        // ⏳ Auto-close after 2 seconds and submit form
        setTimeout(() => {
          const hiddenPay = document.createElement("input");
          hiddenPay.type = "hidden";
          hiddenPay.name = "paymentMethod";
          hiddenPay.value = paymentMethod;
          document.getElementById("enrollmentForm").appendChild(hiddenPay);

          document.getElementById("enrollmentForm").submit();
        }, 2000);

      }, 3000); // simulate 3 seconds of "waiting"
    }
  });
});

</script>
</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showSection(sectionId) {
  document.querySelectorAll("main section").forEach(sec => {
    sec.classList.add("hidden");
  });
  document.getElementById(sectionId).classList.remove("hidden");
}

// Enrollment form dynamic courses & sections
const data = {
  1: { sections: ["11M1", "11A1", "11E1"], courses: ["BSIT", "BSE", "BSBA"] },
  2: { sections: ["21M1", "21A1", "21E1"], courses: ["BSIT", "BSE", "BSBA"] },
  3: { sections: ["31M1", "31A1", "31E1"], courses: ["BSIT", "BSE", "BSBA"] },
  4: { sections: ["41M1", "41A1", "41E1"], courses: ["BSIT", "BSE", "BSBA"] }
};

const yearSelect = document.getElementById("yearLevel");
const sectionSelect = document.getElementById("section");
const courseList = document.getElementById("courseList");

yearSelect.addEventListener("change", () => {
  const year = yearSelect.value;
  sectionSelect.innerHTML = `<option value="">-- Select Section --</option>`;
  courseList.innerHTML = "";
  if (year && data[year]) {
    data[year].sections.forEach(sec => {
      let opt = document.createElement("option");
      opt.value = sec; opt.textContent = sec;
      sectionSelect.appendChild(opt);
    });
    data[year].courses.forEach(course => {
      let div = document.createElement("div");
      div.classList.add("course");
      div.innerHTML = `<input type="radio" name="course" value="${course}"> ${course}`;
      courseList.appendChild(div);
    });
  }
});

// Review enrollment → redirect to payment
document.getElementById("reviewBtn").addEventListener("click", () => {
  const form = document.getElementById("enrollmentForm");
  const name = document.getElementById("studentName").value.trim();
  const year = document.getElementById("yearLevel").value;
  const section = document.getElementById("section").value;
  const course = document.querySelector("input[name='course']:checked");

  if (!name || !year || !section || !course) {
    Swal.fire({ icon: 'warning', title: 'Incomplete Form', text: 'Please complete all fields.' });
    return;
  }

  // Save enrollment info in sessionStorage
  sessionStorage.setItem("enrollmentData", JSON.stringify({
    name, year, section, course: course.value
  }));

  Swal.fire({
    title: 'Enrollment Preview',
    html: `
      <p><strong>Name:</strong> ${name}</p>
      <p><strong>Year Level:</strong> ${year}</p>
      <p><strong>Section:</strong> ${section}</p>
      <p><strong>Course:</strong> ${course.value}</p>
    `,
    icon: 'info',
    confirmButtonText: 'Proceed to Payment'
  }).then(result => {
    if (result.isConfirmed) {
      showSection('payment');
    }
  });
});

// Payment AI Detector
document.getElementById("detectBtn").addEventListener("click", () => {
  const text = document.getElementById("aiText").value.trim();
  const resultDiv = document.getElementById("result");

  if (!text) {
    Swal.fire({ icon: 'warning', title: 'No Text', text: 'Please paste some text first.' });
    return;
  }

  // Simple AI scoring logic
  let aiScore = 0;
  if (text.length > 300) aiScore += 30;
  if (text.includes("Therefore") || text.includes("In conclusion")) aiScore += 25;
  if ((text.match(/,/g) || []).length > 15) aiScore += 20;
  if (text.split(" ").filter(w => w.length > 10).length > 5) aiScore += 25;

  if (aiScore > 60) {
    resultDiv.innerHTML = "🔍 Likely AI-Generated (Score: " + aiScore + "%)";
    resultDiv.style.color = "red";
  } else {
    resultDiv.innerHTML = "✅ Likely Human-Written (Score: " + aiScore + "%)";
    resultDiv.style.color = "green";
  }

  // After detection → finalize enrollment
  Swal.fire({
    title: "Finalize Enrollment?",
    text: "Proceed to submit your enrollment now.",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: "Submit"
  }).then(res => {
    if (res.isConfirmed) {
  Swal.fire({
    icon: "success",
    title: "Enrollment Finalized!",
    text: "Your enrollment has been recorded."
  });
}
  });
});
</script>
</body>
</html>
