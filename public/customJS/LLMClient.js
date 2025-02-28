import Groq from "groq-sdk";

const API_KEY = process.env.GROQ_API_KEY;

const groq = new Groq({ apiKey: API_KEY });

export async function main() {
  const chatCompletion = await getGroqChatCompletion();

  document.write(chatCompletion.choices[0]?.message?.content || "");
}

export async function getGroqChatCompletion() {
  return groq.chat.completions.create({
    messages: [
      {
        role: "user",
        content: "Explain the importance of fast language models",
      },
    ],
    model: "llama-3.3-70b-versatile",
  });
}
