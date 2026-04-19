async function loadProgram() {
  const res = await fetch("api/getProgram.php");
  const item = await res.json();
  const player = document.getElementById("player");
  document.getElementById("title").innerText = item.title || "";

  if (item.type === "video") {
    const offset = getOffsetSeconds(item.start_time);
    player.innerHTML = `
      <video autoplay controls style="width:100%;max-height:80vh">
        <source src="${item.url}" type="video/mp4">
      </video>
    `;
    const vid = player.querySelector("video");
    vid.addEventListener("loadedmetadata", () => {
      if (offset > 0 && offset < vid.duration) {
        vid.currentTime = offset;
      }
    });
  }

  if (item.type === "image") {
    player.innerHTML = `<img src="${item.url}" style="width:100%;max-height:80vh;object-fit:contain;">`;
  }

  if (item.type === "page") {
    player.innerHTML = `<iframe src="${item.url}" style="width:100%;height:80vh;border:none;"></iframe>`;
  }

  // Refresh at next program end
  if (item.end_time) {
    const msUntilEnd = getMsUntil(item.end_time);
    setTimeout(loadProgram, msUntilEnd + 1000);
  } else {
    setTimeout(loadProgram, 60000); // fallback reload every 1 min
  }
}

function getOffsetSeconds(startTime) {
  if (!startTime) return 0;
  const now = new Date();
  const [h, m, s] = startTime.split(":").map(Number);
  const start = new Date();
  start.setHours(h, m, s || 0, 0);
  return Math.floor((now - start) / 1000);
}

function getMsUntil(endTime) {
  const now = new Date();
  const [h, m, s] = endTime.split(":").map(Number);
  const end = new Date();
  end.setHours(h, m, s || 0, 0);
  return end - now;
}

loadProgram();
