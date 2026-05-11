<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();

        if (! $admin || $categories->isEmpty()) {
            return;
        }

        $cat = fn (string $slug) => $categories->firstWhere('slug', $slug)?->id;

        $posts = [
            [
                'title' => 'Understanding the Transformer Architecture',
                'content' => $this->content1(),
                'category_id' => $cat('deep-learning'),
                'status' => 'published',
                'published_at' => now()->subDays(30),
                'tags' => ['Transformers', 'Attention', 'NLP', 'Deep Learning'],
            ],
            [
                'title' => 'Building Scalable Microservices: A Practical Guide',
                'content' => $this->content2(),
                'category_id' => $cat('software-architecture'),
                'status' => 'published',
                'published_at' => now()->subDays(28),
                'tags' => ['Microservices', 'Scalability', 'Architecture', 'Kubernetes'],
            ],
            [
                'title' => 'LLM Fine-Tuning: Best Practices and Pitfalls',
                'content' => $this->content3(),
                'category_id' => $cat('large-language-models'),
                'status' => 'published',
                'published_at' => now()->subDays(26),
                'tags' => ['LLM', 'Fine-Tuning', 'LoRA', 'PEFT'],
            ],
            [
                'title' => 'Event-Driven Architecture Patterns Explained',
                'content' => $this->content4(),
                'category_id' => $cat('system-design'),
                'status' => 'published',
                'published_at' => now()->subDays(24),
                'tags' => ['Event-Driven', 'Kafka', 'Messaging', 'Patterns'],
            ],
            [
                'title' => 'Retrieval-Augmented Generation (RAG) Deep Dive',
                'content' => $this->content5(),
                'category_id' => $cat('large-language-models'),
                'status' => 'published',
                'published_at' => now()->subDays(22),
                'tags' => ['RAG', 'Vector DB', 'Embeddings', 'LLM'],
            ],
            [
                'title' => 'Designing High-Availability Distributed Systems',
                'content' => $this->content6(),
                'category_id' => $cat('system-design'),
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'tags' => ['HA', 'Distributed Systems', 'Redundancy', 'SRE'],
            ],
            [
                'title' => 'Prompt Engineering for Software Developers',
                'content' => $this->content7(),
                'category_id' => $cat('artificial-intelligence'),
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'tags' => ['Prompt Engineering', 'GPT', 'Coding', 'AI'],
            ],
            [
                'title' => 'Distributed Systems Fundamentals Every Engineer Should Know',
                'content' => $this->content8(),
                'category_id' => $cat('system-design'),
                'status' => 'published',
                'published_at' => now()->subDays(16),
                'tags' => ['Distributed Systems', 'CAP Theorem', 'Consensus', 'Raft'],
            ],
            [
                'title' => 'Vector Databases: When and Why to Use Them',
                'content' => $this->content9(),
                'category_id' => $cat('machine-learning'),
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'tags' => ['Vector DB', 'Pinecone', 'Weaviate', 'Embeddings'],
            ],
            [
                'title' => 'API Gateway Patterns for Modern Architectures',
                'content' => $this->content10(),
                'category_id' => $cat('software-architecture'),
                'status' => 'published',
                'published_at' => now()->subDays(13),
                'tags' => ['API Gateway', 'GraphQL', 'REST', 'Microservices'],
            ],
            [
                'title' => 'LLM Agents and Tool Use: Building Autonomous Systems',
                'content' => $this->content11(),
                'category_id' => $cat('large-language-models'),
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'tags' => ['Agents', 'Tool Use', 'ReAct', 'AutoGPT'],
            ],
            [
                'title' => 'CQRS and Event Sourcing: A Complete Guide',
                'content' => $this->content12(),
                'category_id' => $cat('software-architecture'),
                'status' => 'published',
                'published_at' => now()->subDays(11),
                'tags' => ['CQRS', 'Event Sourcing', 'DDD', 'Architecture'],
            ],
            [
                'title' => 'Attention Mechanisms: Beyond the Original Paper',
                'content' => $this->content13(),
                'category_id' => $cat('deep-learning'),
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'tags' => ['Attention', 'Multi-Head', 'Flash Attention', 'Efficiency'],
            ],
            [
                'title' => 'Load Balancing Strategies at Scale',
                'content' => $this->content14(),
                'category_id' => $cat('system-design'),
                'status' => 'published',
                'published_at' => now()->subDays(9),
                'tags' => ['Load Balancing', 'NGINX', 'HAProxy', 'Latency'],
            ],
            [
                'title' => 'Fine-Tuning vs RAG vs Prompt Engineering: Choosing the Right Approach',
                'content' => $this->content15(),
                'category_id' => $cat('large-language-models'),
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'tags' => ['LLM', 'RAG', 'Fine-Tuning', 'Comparison'],
            ],
            [
                'title' => 'Database Sharding Techniques for Horizontal Scaling',
                'content' => $this->content16(),
                'category_id' => $cat('system-design'),
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'tags' => ['Sharding', 'Databases', 'PostgreSQL', 'Scaling'],
            ],
            [
                'title' => 'Multimodal AI: Bridging Vision and Language',
                'content' => $this->content17(),
                'category_id' => $cat('artificial-intelligence'),
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'tags' => ['Multimodal', 'CLIP', 'Vision', 'GPT-4V'],
            ],
            [
                'title' => 'Caching Strategies for High-Performance Applications',
                'content' => $this->content18(),
                'category_id' => $cat('software-architecture'),
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'tags' => ['Caching', 'Redis', 'CDN', 'Performance'],
            ],
            [
                'title' => 'Model Quantization: Running LLMs on Consumer Hardware',
                'content' => $this->content19(),
                'category_id' => $cat('machine-learning'),
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'tags' => ['Quantization', 'GGUF', 'LLaMA', 'Edge AI'],
            ],
            [
                'title' => 'MLOps: CI/CD Pipelines for Machine Learning Models',
                'content' => $this->content20(),
                'category_id' => $cat('mlops'),
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'tags' => ['MLOps', 'CI/CD', 'Kubeflow', 'Deployment'],
            ],
        ];

        foreach ($posts as $data) {
            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $post = BlogPost::create([
                ...$data,
                'user_id' => $admin->id,
            ]);

            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }
    }

    private function content1(): string
    {
        return <<<'HTML'
<p>The Transformer architecture, introduced in the seminal paper <em>"Attention Is All You Need"</em> by Vaswani et al. in 2017, fundamentally changed how we approach sequence modeling in deep learning. Before Transformers, recurrent neural networks (RNNs) and Long Short-Term Memory networks (LSTMs) dominated natural language processing, but they suffered from sequential computation bottlenecks and difficulty capturing long-range dependencies.</p>

<h2>The Core Innovation: Self-Attention</h2>
<p>At the heart of the Transformer lies the <strong>self-attention mechanism</strong>. Unlike RNNs that process tokens one by one, self-attention allows the model to weigh the importance of all other tokens in a sequence when encoding each token. This parallelization is what makes Transformers so efficient to train on modern hardware.</p>

<p>The attention function can be described as mapping a query and a set of key-value pairs to an output. Mathematically:</p>
<pre><code>Attention(Q, K, V) = softmax(QK^T / sqrt(d_k))V</code></pre>

<p>Where Q, K, and V are linear projections of the input embeddings, and d_k is the dimension of the key vectors. The scaling factor sqrt(d_k) prevents the dot products from growing too large in magnitude.</p>

<h2>Multi-Head Attention</h2>
<p>Instead of performing a single attention function, the Transformer uses <strong>multi-head attention</strong>. This allows the model to jointly attend to information from different representation subspaces at different positions:</p>

<pre><code>MultiHead(Q, K, V) = Concat(head_1, ..., head_h)W^O
where head_i = Attention(QW_i^Q, KW_i^K, VW_i^V)</code></pre>

<p>Each head can learn different types of relationships. Some heads might focus on syntactic dependencies, while others capture semantic similarities or long-distance references.</p>

<h2>Positional Encoding</h2>
<p>Since the Transformer has no recurrence or convolution, it needs a way to inject information about token positions. The original paper uses sinusoidal positional encodings:</p>

<pre><code>PE(pos, 2i)   = sin(pos / 10000^(2i/d_model))
PE(pos, 2i+1) = cos(pos / 10000^(2i/d_model))</code></pre>

<p>These encodings allow the model to learn to attend by relative positions, as PE(pos+k) can be represented as a linear function of PE(pos).</p>

<h2>Encoder-Decoder Architecture</h2>
<p>The original Transformer consists of:</p>
<ul>
<li><strong>Encoder:</strong> A stack of N identical layers, each with multi-head self-attention and a position-wise feed-forward network.</li>
<li><strong>Decoder:</strong> Similar layers but with an additional masked multi-head attention to prevent positions from attending to subsequent positions.</li>
</ul>

<h2>Impact and Evolution</h2>
<p>Transformers have become the backbone of modern NLP. BERT uses only the encoder for bidirectional representations. GPT uses only the decoder for autoregressive language modeling. T5 reframes all NLP tasks as text-to-text problems. Vision Transformers (ViT) extended the architecture to computer vision, proving that attention truly is all you need.</p>
HTML;
    }

    private function content2(): string
    {
        return <<<'HTML'
<p>Microservices architecture has become the de facto standard for building large-scale applications. But moving from a monolith to microservices is not just about splitting code—it is about designing for <strong>independence, resilience, and scalability</strong>.</p>

<h2>Service Boundaries: The Hardest Problem</h2>
<p>The most critical decision in microservices is defining service boundaries. Get this wrong, and you end up with a <em>distributed monolith</em>—all the pain of distribution without the benefits of independence. Domain-Driven Design (DDD) and bounded contexts are invaluable here.</p>

<p>A good heuristic: services should align with business capabilities. If two services constantly change together, they probably belong together.</p>

<h2>Inter-Service Communication</h2>
<p>Services need to talk. The two primary patterns are:</p>

<h3>Synchronous (Request-Response)</h3>
<p>HTTP/gRPC calls between services. Simple but introduces tight coupling and cascading failure risks. Always use:</p>
<ul>
<li><strong>Circuit breakers</strong> (e.g., Resilience4j, Polly) to fail fast</li>
<li><strong>Timeouts and retries</strong> with exponential backoff</li>
<li><strong>Idempotency keys</strong> for safe retries</li>
</ul>

<h3>Asynchronous (Event-Driven)</h3>
<p>Message brokers like Kafka, RabbitMQ, or AWS SNS/SQS decouple services. Events enable eventual consistency and better resilience, but add complexity in debugging and reasoning about system state.</p>

<h2>Data Management</h2>
<p>Each service should own its data. This means <strong>database-per-service</strong> pattern. You cannot share databases—doing so violates encapsulation and creates hidden coupling.</p>

<p>When you need data from another service, you have options:</p>
<ul>
<li><strong>API Composition:</strong> Query multiple services and aggregate</li>
<li><strong>Command Query Responsibility Segregation (CQRS):</strong> Maintain read-optimized views</li>
<li><strong>Event Sourcing:</strong> Replay events to reconstruct state</li>
</ul>

<h2>Observability</h2>
<p>In a distributed system, you cannot debug with print statements. You need:</p>
<ul>
<li><strong>Distributed tracing</strong> (OpenTelemetry, Jaeger, Zipkin)</li>
<li><strong>Centralized logging</strong> (ELK stack, Loki)</li>
<li><strong>Metrics and alerting</strong> (Prometheus, Grafana)</li>
</ul>

<h2>Deployment and Scaling</h2>
<p>Container orchestration with Kubernetes is the standard. Use:</p>
<ul>
<li><strong>Horizontal Pod Autoscaling (HPA)</strong> based on CPU/memory or custom metrics</li>
<li><strong>Service meshes</strong> like Istio or Linkerd for traffic management, mTLS, and observability</li>
<li><strong>GitOps</strong> with ArgoCD or Flux for declarative deployments</li>
</ul>

<p>Remember: microservices are not a goal. They are a means to enable team autonomy and system scalability. Start with a well-modularized monolith and extract services when the pain justifies the complexity.</p>
HTML;
    }

    private function content3(): string
    {
        return <<<'HTML'
<p>Fine-tuning Large Language Models has become essential for building production AI applications. While foundation models like GPT-4 and Llama are incredibly capable, they need adaptation for specific domains, tasks, and tone. This guide covers the best practices—and common pitfalls—of LLM fine-tuning.</p>

<h2>When to Fine-Tune</h2>
<p>Before reaching for fine-tuning, consider simpler alternatives:</p>
<ul>
<li><strong>Prompt engineering</strong> often suffices for straightforward tasks</li>
<li><strong>RAG (Retrieval-Augmented Generation)</strong> grounds the model in your data without retraining</li>
<li><strong>Few-shot prompting</strong> teaches the model patterns from examples</li>
</ul>

<p>Fine-tuning makes sense when you need <em>consistent style</em>, <em>specialized knowledge</em>, or <em>lower latency/cost</em> than API calls to large models.</p>

<h2>Parameter-Efficient Fine-Tuning (PEFT)</h2>
<p>Full fine-tuning updates billions of parameters and requires enormous GPU memory. PEFT methods update only a small subset:</p>

<h3>LoRA (Low-Rank Adaptation)</h3>
<p>LoRA injects trainable rank decomposition matrices into each layer of the transformer. Instead of updating W, we learn ΔW = BA where B and A are low-rank matrices.</p>

<pre><code># Typical LoRA config
r = 16               # rank
lora_alpha = 32      # scaling
lora_dropout = 0.05
target_modules = ["q_proj", "v_proj", "k_proj", "o_proj"]</code></pre>

<p>With r=16, you might train only 0.1% of original parameters while achieving 95%+ of full fine-tuning quality.</p>

<h3>QLoRA</h3>
<p>QLoRA quantizes the base model to 4-bit precision (NormalFloat4) and uses paged optimizers to fit large models on single consumer GPUs. You can fine-tune a 70B parameter model on a 48GB GPU.</p>

<h2>Data Preparation</h2>
<p>Garbage in, garbage out. Your dataset quality matters more than hyperparameter tuning:</p>
<ul>
<li>Use diverse, representative examples</li>
<li>Format consistently (instruction-following templates like Alpaca, ShareGPT)</li>
<li>Include negative examples and edge cases</li>
<li>Balance classes and avoid repetitive patterns</li>
</ul>

<h2>Hyperparameters</h2>
<ul>
<li><strong>Learning rate:</strong> Start with 1e-4 to 2e-4 for LoRA. Higher than full fine-tuning.</li>
<li><strong>Batch size:</strong> Larger is better if memory allows. Use gradient accumulation.</li>
<li><strong>Epochs:</strong> Usually 1-3 is enough. More risks overfitting.</li>
<li><strong>Max sequence length:</strong> Truncate or pack sequences efficiently.</li>
</ul>

<h2>Common Pitfalls</h2>
<ul>
<li><strong>Catastrophic forgetting:</strong> The model loses general knowledge. Use techniques like rehearsal or smaller learning rates.</li>
<li><strong>Overfitting:</strong> Small datasets cause the model to memorize. Use regularization, dropout, and early stopping.</li>
<li><strong>Evaluation leakage:</strong> Ensure your test set is truly held out and representative.</li>
<li><strong>Format sensitivity:</strong> The inference prompt format must match training exactly.</li>
</ul>
HTML;
    }

    private function content4(): string
    {
        return <<<'HTML'
<p>Event-driven architecture (EDA) is a paradigm where services communicate by producing and consuming events rather than direct calls. This decoupling enables scalability, resilience, and loose coupling—but introduces new complexities.</p>

<h2>Core Concepts</h2>
<p>An <strong>event</strong> is a statement of fact: "OrderCreated", "PaymentProcessed", "UserSignedUp". Events are immutable and represent something that has already happened.</p>

<p>The key components are:</p>
<ul>
<li><strong>Event Producers:</strong> Services that emit events when state changes</li>
<li><strong>Event Consumers:</strong> Services that react to events</li>
<li><strong>Event Bus/Broker:</strong> The middleware that routes events (Kafka, RabbitMQ, EventBridge)</li>
</ul>

<h2>Common Patterns</h2>

<h3>Event Notification</h3>
<p>The simplest pattern. A producer emits a lightweight event, and consumers fetch details via an API. This reduces payload size and keeps consumers from becoming too coupled to producer schemas.</p>

<h3>Event-Carried State Transfer</h3>
<p>The event contains all the data consumers need. Consumers maintain their own local copies, eliminating the need to query the producer. This enables better autonomy and availability.</p>

<h3>Event Sourcing</h3>
<p>Instead of storing the current state, you store every event that led to it. The state is a fold (reduce) over the event stream. This provides a complete audit log and enables temporal queries.</p>

<h2>Message Broker Comparison</h2>
<table>
<thead><tr><th>Feature</th><th>Kafka</th><th>RabbitMQ</th><th>AWS SNS/SQS</th></tr></thead>
<tbody>
<tr><td>Throughput</td><td>Very High</td><td>High</td><td>High</td></tr>
<tr><td>Persistence</td><td>Yes (disk)</td><td>Optional</td><td>SQS: Yes</td></tr>
<tr><td>Ordering</td><td>Partition-level</td><td>Queue-level</td><td>FIFO queues</td></tr>
<tr><td>Replay</td><td>Yes</td><td>No</td><td>No</td></tr>
<tr><td>Complexity</td><td>High</td><td>Medium</td><td>Low</td></tr>
</tbody>
</table>

<h2>Designing Event Schemas</h2>
<p>Use a schema registry (Confluent Schema Registry, AWS Glue) to enforce forward and backward compatibility. Avro, Protobuf, and JSON Schema are popular choices. Include:</p>
<ul>
<li>Event type and version</li>
<li>Timestamp and correlation ID</li>
<li>Source service identifier</li>
<li>Payload with semantic versioning</li>
</ul>

<h2>Handling Failures</h2>
<ul>
<li><strong>Dead Letter Queues (DLQ):</strong> Route failed messages for inspection</li>
<li><strong>Idempotency:</strong> Consumers must handle duplicate events gracefully</li>
<li><strong>Out-of-order events:</strong> Design for eventual consistency and use sequence numbers</li>
</ul>
HTML;
    }

    private function content5(): string
    {
        return <<<'HTML'
<p>Retrieval-Augmented Generation (RAG) has emerged as the dominant pattern for building domain-specific LLM applications. Instead of fine-tuning a model on private data, RAG retrieves relevant context at inference time and feeds it to the model.</p>

<h2>How RAG Works</h2>
<p>The RAG pipeline has two phases:</p>

<h3>1. Indexing</h3>
<ol>
<li><strong>Chunking:</strong> Documents are split into manageable pieces (512-1024 tokens)</li>
<li><strong>Embedding:</strong> Each chunk is converted to a dense vector using an embedding model</li>
<li><strong>Storage:</strong> Vectors are stored in a vector database with metadata</li>
</ol>

<h3>2. Retrieval and Generation</h3>
<ol>
<li><strong>Query embedding:</strong> The user query is embedded using the same model</li>
<li><strong>Similarity search:</strong> Top-k most similar chunks are retrieved</li>
<li><strong>Augmented prompt:</strong> Retrieved chunks are injected into the prompt context</li>
<li><strong>Generation:</strong> The LLM generates an answer grounded in the retrieved context</li>
</ol>

<h2>Embedding Models</h2>
<p>Choosing the right embedding model is critical. Popular options include:</p>
<ul>
<li><strong>OpenAI text-embedding-3-large:</strong> State-of-the-art general-purpose</li>
<li><strong>Sentence-BERT (all-MiniLM-L6-v2):</strong> Fast, lightweight, open-source</li>
<li><strong>BGE (BAAI/general-large):</strong> Strong performance on academic benchmarks</li>
<li><strong>E5 (intfloat/e5-large-v2):</strong> Optimized for passage retrieval</li>
</ul>

<h2>Chunking Strategies</h2>
<p>Poor chunking destroys retrieval quality:</p>
<ul>
<li><strong>Fixed-size:</strong> Simple but may split semantically related content</li>
<li><strong>Recursive:</strong> Split on semantic boundaries (paragraphs, sentences)</li>
<li><strong>Agentic:</strong> Use an LLM to create summaries or determine chunk boundaries</li>
</ul>

<h2>Advanced RAG Techniques</h2>

<h3>Re-ranking</h3>
<p>First retrieve with a fast bi-encoder (embedding similarity), then re-rank with a slower but more accurate cross-encoder. This improves precision with minimal latency cost.</p>

<h3>Query Expansion</h3>
<p>Use an LLM to generate hypothetical answers or reformulate queries before retrieval. Hypothetical Document Embedding (HyDE) generates a fake answer and retrieves real documents similar to it.</p>

<h3>Self-Reflection</h3>
<p>Ask the LLM to evaluate whether its answer is supported by the retrieved context. If not, iterate or respond with "I don't know." This reduces hallucinations significantly.</p>

<h2>Evaluation</h2>
<p>RAG evaluation requires metrics for both retrieval and generation:</p>
<ul>
<li><strong>Retrieval:</strong> Hit rate, MRR, NDCG</li>
<li><strong>Generation:</strong> Faithfulness, answer relevance, context precision</li>
<li><strong>End-to-end:</strong> Use frameworks like RAGAS or TruLens</li>
</ul>
HTML;
    }

    private function content6(): string
    {
        return <<<'HTML'
<p>High availability (HA) is the ability of a system to remain operational for a desirably long time. For modern web services, this typically means 99.99% uptime ("four nines") or higher. Achieving this requires deliberate design at every layer.</p>

<h2>Defining Availability Targets</h2>
<table>
<thead><tr><th>Availability</th><th>Downtime/Year</th><th>Use Case</th></tr></thead>
<tbody>
<tr><td>99% (two nines)</td><td>3.65 days</td><td>Internal tools</td></tr>
<tr><td>99.9% (three nines)</td><td>8.76 hours</td><td>Most SaaS products</td></tr>
<tr><td>99.99% (four nines)</td><td>52.6 minutes</td><td>Payment systems</td></tr>
<tr><td>99.999% (five nines)</td><td>5.26 minutes</td><td>Telecom, medical</td></tr>
</tbody>
</table>

<h2>Redundancy Strategies</h2>

<h3>Active-Active</h3>
<p>Multiple instances serve traffic simultaneously. Load balancers distribute requests. If one fails, traffic routes to healthy instances. This is the most scalable but complex pattern.</p>

<h3>Active-Passive</h3>
<p>A primary instance handles traffic while a standby replica stays ready. On failure, failover promotes the replica. Simpler but wastes resources during normal operation.</p>

<h2>Eliminating Single Points of Failure</h2>
<p>Every component must be redundant:</p>
<ul>
<li><strong>Compute:</strong> Auto-scaling groups across availability zones</li>
<li><strong>Databases:</strong> Multi-AZ replication, read replicas</li>
<li><strong>Load Balancers:</strong> Use managed services (AWS ALB, Cloudflare) with built-in redundancy</li>
<li><strong>DNS:</strong> Multiple name servers, health-checked failover records</li>
<li><strong>Power and Network:</strong> Data center level redundancy (handled by cloud providers)</li>
</ul>

<h2>Failure Detection and Recovery</h2>
<p>Availability is not just about preventing failure—it is about recovering fast:</p>

<h3>Health Checks</h3>
<p>Use layered health checks:</p>
<ul>
<li><strong>Liveness:</strong> Is the process running?</li>
<li><strong>Readiness:</strong> Is it ready to accept traffic?</li>
<li><strong>Deep:</strong> Can it connect to dependencies (database, cache)?</li>
</ul>

<h3>Circuit Breakers</h3>
<p>When a dependency fails repeatedly, the circuit breaker trips and returns a fallback response. This prevents cascading failures and gives the failing service time to recover.</p>

<h3>Graceful Degradation</h3>
<p>When non-critical services fail, continue operating with reduced functionality. Netflix's "Chaos Monkey" randomly kills instances in production to ensure graceful degradation works.</p>

<h2>Data Durability</h2>
<p>Availability without durability is useless. Implement:</p>
<ul>
<li>Synchronous replication for critical data</li>
<li>Regular backups with tested restore procedures</li>
<li>Point-in-time recovery capabilities</li>
<li>Multi-region replication for disaster recovery</li>
</ul>
HTML;
    }

    private function content7(): string
    {
        return <<<'HTML'
<p>Prompt engineering is the practice of crafting inputs to get the best possible outputs from Large Language Models. For developers, it is not just about asking questions—it is about designing interfaces between human intent and machine capability.</p>

<h2>Core Principles</h2>

<h3>Be Specific and Explicit</h3>
<p>Vague prompts produce vague outputs. Instead of "Explain Python," use:</p>
<blockquote>"Explain Python list comprehensions to a developer familiar with JavaScript array methods. Include syntax, performance characteristics, and three practical examples."</blockquote>

<h3>Use Structured Formats</h3>
<p>LLMs respond well to structure. Use delimiters, markdown, or explicit sections:</p>
<pre><code>Summarize the following article.
Use this format:
- Main Point: [one sentence]
- Key Insights: [bullet list]
- Action Items: [numbered list]

Article:
"""{article}"""</code></pre>

<h2>Advanced Techniques</h2>

<h3>Chain-of-Thought (CoT)</h3>
<p>For reasoning tasks, ask the model to think step by step:</p>
<blockquote>"Solve this math problem. Show your reasoning step by step before giving the final answer."</blockquote>

<p>This dramatically improves accuracy on complex problems. You can also provide examples of step-by-step reasoning in few-shot prompts.</p>

<h3>ReAct (Reasoning + Acting)</h3>
<p>Combine reasoning with tool use. The model alternates between thinking and taking actions:</p>
<pre><code>Question: What is the weather in Tokyo?
Thought: I need to find the current weather in Tokyo.
Action: search_weather("Tokyo")
Observation: {"temp": 22, "condition": "Sunny"}
Thought: I have the weather data.
Final Answer: It is 22°C and sunny in Tokyo.</code></pre>

<h3>Self-Consistency</h3>
<p>Generate multiple answers with different reasoning paths, then vote on the most common result. This reduces random errors at the cost of more tokens.</p>

<h2>Role Prompting</h2>
<p>Assigning a persona helps the model adopt the right tone and expertise:</p>
<blockquote>"You are a senior Site Reliability Engineer reviewing a Terraform configuration. Identify security issues, cost optimizations, and reliability concerns. Be concise and actionable."</blockquote>

<h2>Context Window Management</h2>
<p>With limited context windows, prioritize what you include:</p>
<ul>
<li>Put the most important instructions at the beginning and end</li>
<li>Use summaries instead of full documents when possible</li>
<li>Remove boilerplate and redundant information</li>
<li>For code reviews, focus on changed lines with minimal surrounding context</li>
</ul>

<h2>Evaluating Prompts</h2>
<p>Treat prompts like code. Version control them, test against edge cases, and measure:</p>
<ul>
<li><strong>Accuracy:</strong> Is the output correct?</li>
<li><strong>Consistency:</strong> Does it vary across runs?</li>
<li><strong>Robustness:</strong> Does it handle adversarial or unusual inputs?</li>
</ul>
HTML;
    }

    private function content8(): string
    {
        return <<<'HTML'
<p>Distributed systems power every major application we use today. Understanding their fundamental principles is essential for building reliable software at scale. This post covers the core concepts every engineer should internalize.</p>

<h2>Fallacies of Distributed Computing</h2>
<p>Peter Deutsch famously listed eight fallacies that engineers assume:</p>
<ol>
<li>The network is reliable.</li>
<li>Latency is zero.</li>
<li>Bandwidth is infinite.</li>
<li>The network is secure.</li>
<li>Topology does not change.</li>
<li>There is one administrator.</li>
<li>Transport cost is zero.</li>
<li>The network is homogeneous.</li>
</ol>

<p>Every one of these is false. Design your systems assuming network partitions, variable latency, and Byzantine failures.</p>

<h2>The CAP Theorem</h2>
<p>In a distributed data store, you can only guarantee two of three properties:</p>
<ul>
<li><strong>Consistency:</strong> Every read receives the most recent write</li>
<li><strong>Availability:</strong> Every request receives a response</li>
<li><strong>Partition Tolerance:</strong> The system continues despite network partitions</li>
</ul>

<p>Since network partitions are inevitable, the real choice is between CP and AP systems. Databases like Cassandra choose AP (eventual consistency), while Spanner and etcd choose CP (strong consistency).</p>

<h2>Consensus Algorithms</h2>
<p>When multiple nodes must agree on a value, you need consensus:</p>

<h3>Raft</h3>
<p>Raft is a consensus algorithm designed to be understandable. It separates the problem into:</p>
<ul>
<li><strong>Leader Election:</strong> Nodes vote for a leader</li>
<li><strong>Log Replication:</strong> The leader replicates commands to followers</li>
<li><strong>Safety:</strong> Ensures committed entries are durable</li>
</ul>

<p>etcd, Consul, and TiKV all use Raft. It is the default choice for new systems.</p>

<h3>Paxos</h3>
<p>Paxos is the classic consensus algorithm, notoriously difficult to implement correctly. It is the theoretical foundation, but most practitioners prefer Raft for its clarity.</p>

<h2>Clocks and Time</h2>
<p>Time is surprisingly hard in distributed systems:</p>
<ul>
<li><strong>Physical clocks</strong> drift (NTP helps but is not perfect)</li>
<li><strong>Logical clocks</strong> (Lamport timestamps, vector clocks) track causality, not physical time</li>
<li><strong>TrueTime</strong> (Google Spanner) uses atomic clocks and GPS to bound uncertainty</li>
</ul>

<h2>Byzantine Fault Tolerance</h2>
<p>What if nodes lie? Byzantine Fault Tolerant (BFT) algorithms handle malicious or arbitrary failures. PBFT and modern blockchain consensus (like Tendermint) use BFT. They require 3f+1 nodes to tolerate f failures.</p>

<h2>Idempotency</h2>
<p>Operations should be safe to retry. An idempotent operation produces the same result whether executed once or many times. Use:</p>
<ul>
<li>Idempotency keys for write operations</li>
<li>Natural keys or composite identifiers</li>
<li>State machine patterns where transitions are idempotent</li>
</ul>
HTML;
    }

    private function content9(): string
    {
        return <<<'HTML'
<p>Vector databases have exploded in popularity alongside the rise of LLMs and embeddings. They are purpose-built for similarity search over high-dimensional vectors—something traditional databases struggle with.</p>

<h2>Why Vector Databases?</h2>
<p>Traditional indexes (B-trees, hash indexes) work on exact matches or range queries. But embeddings exist in a continuous semantic space where "close" vectors represent similar meanings. Vector databases use approximate nearest neighbor (ANN) algorithms to find similar vectors efficiently.</p>

<h2>Core Concepts</h2>

<h3>Embeddings</h3>
<p>An embedding is a dense vector representation of data. Text, images, audio, and even code can be embedded. A sentence might become a 768-dimensional or 1536-dimensional vector.</p>

<h3>Similarity Metrics</h3>
<ul>
<li><strong>Cosine Similarity:</strong> Measures the angle between vectors. Most common for text.</li>
<li><strong>Euclidean Distance:</strong> Straight-line distance. Good for spatial data.</li>
<li><strong>Dot Product:</strong> Fast and effective when vectors are normalized.</li>
</ul>

<h3>ANN Algorithms</h3>
<p>Exact nearest neighbor search is O(n) and too slow for millions of vectors. ANN algorithms trade a tiny accuracy loss for massive speedups:</p>

<h4>HNSW (Hierarchical Navigable Small World)</h4>
<p>Builds a multi-layer graph where upper layers are sparse and lower layers are dense. Search starts at the top and descends. Extremely fast with high recall. Used by Weaviate and pgvector.</p>

<h4>IVF (Inverted File Index)</h4>
<p>Clusters vectors with k-means and searches only the nearest clusters. Good balance of speed and memory. Used by FAISS and Milvus.</p>

<h4>Locality-Sensitive Hashing (LSH)</h4>
<p>Hashes similar vectors to the same buckets with high probability. Simple but less accurate than HNSW for high dimensions.</p>

<h2>Popular Vector Databases</h2>
<table>
<thead><tr><th>Database</th><th>Type</th><th>Best For</th></tr></thead>
<tbody>
<tr><td>Pinecone</td><td>Managed</td><td>Production, no ops</td></tr>
<tr><td>Weaviate</td><td>Open-source</td><td>Graph + vector hybrid</td></tr>
<tr><td>pgvector</td><td>Postgres extension</td><td>Existing PostgreSQL users</td></tr>
<tr><td>Milvus/Zilliz</td><td>Open/Managed</td><td>Massive scale</td></tr>
<tr><td>Chroma</td><td>Embedded</td><td>Prototyping, local dev</td></tr>
</tbody>
</table>

<h2>When to Use Vector Search</h2>
<ul>
<li>Semantic search (find similar meaning, not just keyword matches)</li>
<li>Recommendation engines (user/item embeddings)</li>
<li>Anomaly detection (outliers in embedding space)</li>
<li>Image/audio search (multimodal embeddings)</li>
<li>RAG applications (retrieval for LLM context)</li>
</ul>

<h2>Hybrid Search</h2>
<p>Combine vector similarity with traditional filters (date ranges, categories, metadata). Most vector DBs support metadata filtering alongside ANN search.</p>
HTML;
    }

    private function content10(): string
    {
        return <<<'HTML'
<p>The API Gateway is a critical component in modern microservices architecture. It sits between clients and backend services, handling cross-cutting concerns like routing, authentication, rate limiting, and protocol translation.</p>

<h2>Core Responsibilities</h2>

<h3>Request Routing</h3>
<p>The gateway maps incoming requests to appropriate backend services. This decouples clients from service topology. You can refactor, split, or merge services without changing client code.</p>

<h3>Authentication and Authorization</h3>
<p>Centralize auth at the edge. The gateway validates JWTs, API keys, or OAuth tokens before forwarding requests. Services downstream can trust that requests are authenticated.</p>

<h3>Rate Limiting and Throttling</h3>
<p>Protect backends from traffic spikes. Implement per-client, per-endpoint, or global rate limits. Use algorithms like token bucket or sliding window counter.</p>

<h3>Load Balancing</h3>
<p>Distribute traffic across healthy instances. Support strategies like round-robin, least connections, or consistent hashing for cache affinity.</p>

<h3>Caching</h3>
<p>Cache responses at the gateway to reduce backend load. Use cache-control headers, ETags, and TTL-based invalidation.</p>

<h2>Gateway Patterns</h2>

<h3>Gateway Aggregation</h3>
<p>When a page needs data from multiple services, the gateway makes parallel calls and returns a single aggregated response. This reduces client-side complexity and network round trips.</p>

<h3>Gateway Offloading</h3>
<p>Move cross-cutting concerns out of services and into the gateway: SSL termination, request logging, CORS handling, and request/response transformation.</p>

<h3>Backend for Frontend (BFF)</h3>
<p>Create separate gateways for different client types (web, mobile, IoT). Each BFF is optimized for its client's needs, allowing the mobile app to receive lightweight payloads while the web app gets richer data.</p>

<h2>Technology Choices</h2>
<table>
<thead><tr><th>Solution</th><th>Type</th><th>Best For</th></tr></thead>
<tbody>
<tr><td>Kong</td><td>Open-source</td><td>Plugin ecosystem, Lua extensibility</td></tr>
<tr><td>NGINX / OpenResty</td><td>Open-source</td><td>High performance, custom Lua</td></tr>
<tr><td>Envoy</td><td>Open-source</td><td>Service mesh integration</td></tr>
<tr><td>AWS API Gateway</td><td>Managed</td><td>AWS-native, serverless</td></tr>
<tr><td>Azure APIM</td><td>Managed</td><td>Azure ecosystem</td></tr>
</tbody>
</table>

<h2>GraphQL Gateways</h2>
<p>Apollo Federation and Schema Stitching allow you to compose multiple GraphQL services into a unified graph. The gateway handles query planning, delegation, and result merging.</p>

<h2>Pitfalls</h2>
<ul>
<li><strong>Overloading the gateway:</strong> Do not put business logic in the gateway</li>
<li><strong>Single point of failure:</strong> Gateways must be redundant and horizontally scalable</li>
<li><strong>Cold start latency:</strong> Serverless gateways can have unpredictable latency</li>
</ul>
HTML;
    }

    private function content11(): string
    {
        return <<<'HTML'
<p>LLM agents represent the next frontier in AI applications. Unlike simple chatbots, agents can reason, plan, use tools, and take actions autonomously. This post explores how to build reliable agent systems.</p>

<h2>What Is an Agent?</h2>
<p>An agent is an LLM-powered system that:</p>
<ul>
<li>Perceives its environment (through text, APIs, or sensors)</li>
<li>Reasons about goals and plans</li>
<li>Acts by calling tools or generating outputs</li>
<li>Learns from feedback and observations</li>
</ul>

<h2>The ReAct Pattern</h2>
<p>ReAct (Reasoning + Acting) is the foundational pattern for LLM agents. The model alternates between thinking and acting:</p>

<pre><code>Thought: I need to find the CEO of Acme Corp.
Action: search("Acme Corp CEO")
Observation: "Jane Doe has been CEO since 2021."
Thought: I have the answer.
Final Answer: Jane Doe is the CEO of Acme Corp.</code></pre>

<p>This simple loop is surprisingly powerful. It grounds the LLM in real-world information and reduces hallucinations.</p>

<h2>Tool Use</h2>
<p>Tools extend an LLM's capabilities beyond text generation. Common tools include:</p>
<ul>
<li><strong>Search:</strong> Web search, internal document search</li>
<li><strong>Calculators:</strong> Python REPL, Wolfram Alpha</li>
<li><strong>APIs:</strong> CRM, calendar, email, databases</li>
<li><strong>Code execution:</strong> Running and testing code</li>
</ul>

<p>Tools are typically defined with JSON schemas:</p>
<pre><code>{
  "name": "get_weather",
  "description": "Get current weather for a city",
  "parameters": {
    "type": "object",
    "properties": {
      "city": {"type": "string"}
    },
    "required": ["city"]
  }
}</code></pre>

<h2>Planning and Reflection</h2>
<p>Simple agents react step by step. Advanced agents use:</p>
<ul>
<li><strong>Planning:</strong> Break complex goals into subtasks before execution</li>
<li><strong>Reflection:</strong> Evaluate results and retry if needed</li>
<li><strong>Memory:</strong> Short-term (conversation history) and long-term (vector stores)</li>
</ul>

<h2>Multi-Agent Systems</h2>
<p>Multiple specialized agents can collaborate:</p>
<ul>
<li><strong>CrewAI:</strong> Role-based agents with delegation</li>
<li><strong>AutoGen:</strong> Conversational agents that can chat with each other</li>
<li><strong>LangGraph:</strong> Stateful multi-actor workflows with cycles</li>
</ul>

<h2>Safety and Control</h2>
<p>Autonomy brings risk. Mitigate with:</p>
<ul>
<li><strong>Human-in-the-loop:</strong> Require approval for critical actions</li>
<li><strong>Tool permissions:</strong> Restrict what tools can do (read-only vs write)</li>
<li><strong>Timeouts and limits:</strong> Prevent infinite loops</li>
<li><strong>Auditing:</strong> Log all agent decisions for review</li>
</ul>
HTML;
    }

    private function content12(): string
    {
        return <<<'HTML'
<p>CQRS (Command Query Responsibility Segregation) and Event Sourcing are powerful patterns for complex domains. They trade simplicity for scalability, auditability, and domain clarity. Used together, they form the backbone of many modern event-driven systems.</p>

<h2>CQRS: Separating Reads from Writes</h2>
<p>In traditional CRUD applications, the same data model serves both reads and writes. This creates tension: read models need denormalized, query-optimized structures, while write models need transactional consistency and validation.</p>

<p>CQRS splits these responsibilities:</p>
<ul>
<li><strong>Command side:</strong> Handles writes, validation, and business logic. Uses the full domain model.</li>
<li><strong>Query side:</strong> Handles reads via optimized, denormalized projections. Can be a separate database entirely.</li>
</ul>

<h2>Event Sourcing: State as a Derivative</h2>
<p>Event Sourcing stores every state change as an immutable event, rather than just the current state. The current state is computed by replaying events.</p>

<p>For example, a bank account is not stored as a balance. Instead, you store:</p>
<pre><code>AccountCreated { accountId, initialBalance }
DepositMade { accountId, amount, timestamp }
WithdrawalMade { accountId, amount, timestamp }
TransferSent { accountId, targetAccount, amount }</code></pre>

<p>The balance is a fold over these events.</p>

<h2>Why Use Them Together?</h2>
<p>CQRS and Event Sourcing complement each other perfectly:</p>
<ul>
<li>Events from the command side naturally feed read model projections</li>
<li>Multiple read models can project the same events differently</li>
<li>Temporal queries become possible ("What was the balance on March 1st?")</li>
<li>The event stream is a complete audit log</li>
</ul>

<h2>Projections</h2>
<p>A projection is a read model built from events. You can have many projections for the same event stream:</p>
<ul>
<li>SQL database for complex queries</li>
<li>Elasticsearch for full-text search</li>
<li>Redis for fast lookups</li>
<li>Graph database for relationship queries</li>
</ul>

<p>Projections are eventually consistent. When a command commits an event, projections update asynchronously.</p>

<h2>Snapshots</h2>
<p>Replaying thousands of events for every aggregate load is slow. Snapshots save the aggregate state periodically, so you only replay events since the last snapshot.</p>

<h2>Challenges</h2>
<ul>
<li><strong>Event schema evolution:</strong> Old events must remain readable. Use versioning and upcasters.</li>
<li><strong>Complexity:</strong> Not every domain needs this. CRUD is fine for simple cases.</li>
<li><strong>Consistency:</strong> Projections are eventually consistent. Design UIs accordingly.</li>
</ul>
HTML;
    }

    private function content13(): string
    {
        return <<<'HTML'
<p>The attention mechanism has evolved dramatically since its introduction in the Transformer paper. From the original scaled dot-product attention to Flash Attention and beyond, these innovations have made training larger models feasible.</p>

<h2>The Original Scaled Dot-Product Attention</h2>
<p>Attention computes a weighted sum of values, where weights are determined by compatibility between queries and keys:</p>

<pre><code>Attention(Q, K, V) = softmax(QK^T / sqrt(d_k))V</code></pre>

<p>The computational complexity is O(n^2 · d) for sequence length n and dimension d. The memory complexity is also O(n^2) for the attention matrix. For long sequences, this becomes the bottleneck.</p>

<h2>Flash Attention</h2>
<p>Flash Attention (Dao et al., 2022) reformulates attention to reduce memory usage and increase speed through:</p>
<ul>
<li><strong>Tiling:</strong> Break the attention computation into blocks that fit in SRAM</li>
<li><strong>Recomputation:</strong> Recompute attention weights during backward pass instead of storing them</li>
<li><strong>Fused kernels:</strong> Combine multiple operations into a single CUDA kernel to reduce HBM reads/writes</li>
</ul>

<p>The result is 2-4x speedup and the ability to train with 5-20x longer sequences on the same hardware.</p>

<h2>Multi-Query Attention (MQA)</h2>
<p>In standard multi-head attention, each head has its own K and V projections. MQA shares a single K and V across all heads, reducing memory bandwidth during autoregressive decoding by ~80%. The quality impact is minimal.</p>

<h2>Grouped-Query Attention (GQA)</h2>
<p>GQA is a compromise between MHA and MQA. It groups heads to share K and V projections. For example, with 8 query heads and 2 key/value heads, each KV head serves 4 query heads. This balances memory efficiency and model quality.</p>

<h2>Sliding Window Attention</h2>
<p>Not all tokens need to attend to all other tokens. Sliding window attention limits each token to attend only to a fixed-size local window. Longformer and Mistral use this pattern, achieving linear attention complexity.</p>

<h2>Sparse Attention Patterns</h2>
<ul>
<li><strong>Strided:</strong> Attend to every k-th token</li>
<li><strong>Dilated:</strong> Skip tokens within the window</li>
<li><strong>Global tokens:</strong> Special tokens that attend to/from all positions</li>
<li><strong>BigBird:</strong> Combines random, window, and global attention</li>
</ul>

<h2>Linear Attention</h2>
<p>Methods like Performer and Linformer approximate softmax attention with linear complexity. Performer uses random feature maps (FAVOR+) to approximate the softmax kernel. These are particularly valuable for very long sequences.</p>
HTML;
    }

    private function content14(): string
    {
        return <<<'HTML'
<p>Load balancing is the art of distributing incoming traffic across multiple servers. Done well, it maximizes throughput, minimizes response time, and prevents any single server from becoming a bottleneck.</p>

<h2>Load Balancer Types</h2>

<h3>Layer 4 (Transport Layer)</h3>
<p>Operates on TCP/UDP connections. It is fast because it does not inspect packet contents. Decisions are based on IP address, port, and connection metadata. Examples: AWS NLB, HAProxy in TCP mode.</p>

<h3>Layer 7 (Application Layer)</h3>
<p>Inspects HTTP headers, cookies, and URL paths. Enables content-based routing, SSL termination, and request rewriting. Examples: AWS ALB, NGINX, Envoy.</p>

<h2>Load Balancing Algorithms</h2>

<h3>Round Robin</h3>
<p>Distributes requests sequentially. Simple and fair when all servers are equal. Fails when servers have different capacities or request processing times vary.</p>

<h3>Least Connections</h3>
<p>Sends traffic to the server with the fewest active connections. Better for long-lived connections or when request processing times vary.</p>

<h3>Least Response Time</h3>
<p>Routes to the server with the lowest average response time. Requires continuous health monitoring and can be sensitive to outlier measurements.</p>

<h3>IP Hash</h3>
<p>Hashes the client IP to determine the server. Ensures session affinity—requests from the same client always hit the same server. Useful for stateful applications.</p>

<h3>Consistent Hashing</h3>
<p>Maps both requests and servers to a ring. When servers are added or removed, only a fraction of keys need remapping. Essential for distributed caching systems.</p>

<h2>Health Checks</h2>
<p>A load balancer is only as good as its health detection:</p>
<ul>
<li><strong>Active:</strong> Periodically ping endpoints</li>
<li><strong>Passive:</strong> Monitor response codes and latency from real traffic</li>
<li><strong>Outlier detection:</strong> Eject servers that consistently underperform</li>
</ul>

<h2>Global Server Load Balancing (GSLB)</h2>
<p>For multi-region deployments, DNS-based GSLB routes users to the nearest healthy region. Services like AWS Route 53, Cloudflare Load Balancing, and NS1 use health checks and geographic proximity.</p>

<h2>Connection Draining</h2>
<p>When removing a server from rotation, allow in-flight requests to complete before terminating connections. This prevents dropped requests during deployments or scaling events.</p>

<h2>Rate Limiting at the Edge</h2>
<p>Load balancers are the ideal place for rate limiting. Implement token bucket or sliding window algorithms to protect backends from abuse and traffic spikes.</p>
HTML;
    }

    private function content15(): string
    {
        return <<<'HTML'
<p>When building LLM applications, you face a fundamental choice: should you fine-tune the model, implement RAG, or rely on prompt engineering? The answer depends on your requirements, constraints, and data.</p>

<h2>Prompt Engineering: The Baseline</h2>
<p><strong>What it is:</strong> Crafting inputs to guide model behavior without changing weights.</p>

<p><strong>Pros:</strong></p>
<ul>
<li>Zero infrastructure cost</li>
<li>Immediate iteration</li>
<li>No data collection needed</li>
<li>Preserves general knowledge</li>
</ul>

<p><strong>Cons:</strong></p>
<ul>
<li>Limited by context window</li>
<li>Cannot learn proprietary domain knowledge</li>
<li>Inconsistent adherence to complex instructions</li>
</ul>

<p><strong>Best for:</strong> General tasks, quick prototypes, one-off queries.</p>

<h2>RAG: Grounding in External Knowledge</h2>
<p><strong>What it is:</strong> Retrieving relevant documents and injecting them into the prompt context.</p>

<p><strong>Pros:</strong></p>
<ul>
<li>No retraining required</li>
<li>Knowledge updates in real-time</li>
<li>Reduced hallucinations via grounding</li>
<li>Explainable (source attribution)</li>
</ul>

<p><strong>Cons:</strong></p>
<ul>
<li>Retrieval quality is a bottleneck</li>
<li>Context window limits document coverage</li>
<li>Latency from retrieval step</li>
</ul>

<p><strong>Best for:</strong> Question-answering over private documents, customer support bots, research assistants.</p>

<h2>Fine-Tuning: Teaching the Model</h2>
<p><strong>What it is:</strong> Updating model weights on a task-specific dataset.</p>

<p><strong>Pros:</strong></p>
<ul>
<li>Consistent style and formatting</li>
<li>No retrieval latency</li>
<li>Learns implicit patterns in data</li>
<li>Can reduce model size needed for a task</li>
</ul>

<p><strong>Cons:</strong></p>
<ul>
<li>Requires curated training data</li>
<li>Risk of catastrophic forgetting</li>
<li>Compute cost for training</li>
<li>Knowledge becomes stale</li>
</ul>

<p><strong>Best for:</strong> Consistent tone, specialized formats, latency-sensitive applications.</p>

<h2>Decision Framework</h2>
<table>
<thead><tr><th>Factor</th><th>Prompt Engineering</th><th>RAG</th><th>Fine-Tuning</th></tr></thead>
<tbody>
<tr><td>Data Privacy</td><td>High</td><td>High</td><td>High</td></tr>
<tr><td>Knowledge Freshness</td><td>N/A</td><td>Real-time</td><td>Static</td></tr>
<tr><td>Setup Complexity</td><td>Low</td><td>Medium</td><td>High</td></tr>
<tr><td>Cost per Query</td><td>High (tokens)</td><td>High (tokens + retrieval)</td><td>Low (smaller model)</td></tr>
<tr><td>Consistency</td><td>Low</td><td>Medium</td><td>High</td></tr>
</tbody>
</table>

<h2>The Hybrid Approach</h2>
<p>Most production systems use all three: fine-tune for style and format, RAG for domain knowledge, and advanced prompting for reasoning. The key is measuring what actually improves your end-to-end metric.</p>
HTML;
    }

    private function content16(): string
    {
        return <<<'HTML'
<p>As data grows, vertical scaling (bigger servers) eventually hits physical and economic limits. Database sharding splits data horizontally across multiple servers, enabling near-linear scalability.</p>

<h2>What Is Sharding?</h2>
<p>Sharding partitions data so each shard contains a subset of the total dataset. A routing layer directs queries to the appropriate shard. Shards can live on separate machines, data centers, or even cloud regions.</p>

<h2>Sharding Strategies</h2>

<h3>Hash-Based Sharding</h3>
<p>A hash function determines the shard for each key:</p>
<pre><code>shard = hash(user_id) % num_shards</code></pre>

<p><strong>Pros:</strong> Even distribution, simple implementation</p>
<p><strong>Cons:</strong> Rebalancing is expensive when adding shards; cannot do range queries across shards</p>

<h3>Range-Based Sharding</h3>
<p>Data is partitioned by key ranges:</p>
<pre><code>Shard 1: user_id 1 - 1,000,000
Shard 2: user_id 1,000,001 - 2,000,000</code></pre>

<p><strong>Pros:</strong> Efficient range queries; easy to add new ranges</p>
<p><strong>Cons:</strong> Hot spots if data is not evenly distributed</p>

<h3>Directory-Based Sharding</h3>
<p>A lookup service maps keys to shards. This allows flexible, dynamic assignment.</p>

<p><strong>Pros:</strong> Fine-grained control; easy rebalancing</p>
<p><strong>Cons:</strong> Lookup service is a single point of contention</p>

<h3>Entity-Based (Schema) Sharding</h3>
<p>Different tables go to different shards. For example, user profiles on one shard and orders on another.</p>

<h2>Cross-Shard Queries</h2>
<p>The hardest part of sharding is handling queries that span multiple shards:</p>
<ul>
<li><strong>Scatter-gather:</strong> Broadcast the query to all shards, then aggregate results</li>
<li><strong>Global tables:</strong> Replicate small reference tables to every shard</li>
<li><strong>Application-level joins:</strong> Fetch data from multiple shards and join in application code</li>
</ul>

<h2>Rebalancing</h2>
<p>Over time, shards become unevenly loaded. Rebalancing moves data between shards:</p>
<ul>
<li><strong>Consistent hashing:</strong> Minimizes data movement when adding/removing nodes</li>
<li><strong>Resharding:</strong> Split hot shards into smaller pieces</li>
<li><strong>Background migration:</strong> Move data gradually to avoid downtime</li>
</ul>

<h2>Managed Solutions</h2>
<p>Modern databases handle sharding automatically:</p>
<ul>
<li><strong>CockroachDB:</strong> Automatic range-based sharding with Raft consensus</li>
<li><strong>MongoDB:</strong> Configurable sharding with balancer</li>
<li><strong>AWS Aurora Limitless:</strong> Automatic horizontal scaling for PostgreSQL</li>
<li><strong>Spanner:</strong> Automatic sharding with strong consistency</li>
</ul>

<h2>When Not to Shard</h2>
<p>Sharding adds significant complexity. Consider alternatives first:</p>
<ul>
<li>Read replicas for read-heavy workloads</li>
<li>Partitioning (logical separation within one database)</li>
<li>Caching layers (Redis, CDN)</li>
<li>Archiving old data</li>
</ul>
HTML;
    }

    private function content17(): string
    {
        return <<<'HTML'
<p>Multimodal AI models can process and reason across multiple types of data—text, images, audio, and video. Models like GPT-4V, Gemini, and CLIP are breaking down the barriers between modalities, enabling entirely new categories of applications.</p>

<h2>What Makes a Model Multimodal?</h2>
<p>Traditional AI models are unimodal: they process one type of input. Multimodal models use a shared representation space where different modalities are embedded into the same vector space. This allows the model to reason about relationships between text and images, or audio and video.</p>

<h2>Key Architectures</h2>

<h3>CLIP (Contrastive Language-Image Pre-training)</h3>
<p>CLIP learns joint text-image embeddings by training on 400 million image-text pairs. It uses a contrastive loss to pull matching pairs together and push non-matching pairs apart.</p>

<p>Applications include:</p>
<ul>
<li>Zero-shot image classification</li>
<li>Semantic image search</li>
<li>Text-guided image generation (DALL-E, Stable Diffusion)</li>
</ul>

<h3>Vision Transformers (ViT)</h3>
<p>ViT applies the Transformer architecture to images by splitting them into patches and treating each patch as a token. Combined with text transformers, this creates powerful vision-language models.</p>

<h3>Flamingo and GPT-4V</h3>
<p>These models can accept interleaved text and images in context, answer questions about visual content, and perform visual reasoning tasks. They use adapter layers to connect pre-trained vision and language models.</p>

<h2>Training Strategies</h2>

<h3>Alignment</h3>
<p>Train encoders for each modality separately, then align them in a shared space. This is efficient but may not capture fine-grained cross-modal relationships.</p>

<h3>Fusion</h3>
<p>Train a single model on multiple modalities from scratch. This is data-hungry but can learn deeper cross-modal patterns.</p>

<h3>Adapter-Based</h3>
<p>Freeze a strong pre-trained model (e.g., LLM) and train lightweight adapter layers to connect new modalities. This is compute-efficient and preserves the base model's capabilities.</p>

<h2>Applications</h2>
<ul>
<li><strong>Visual question answering:</strong> "What color is the car in this image?"</li>
<li><strong>Document understanding:</strong> Extracting information from invoices, forms, and reports</li>
<li><strong>Video analysis:</strong> Summarizing events, detecting anomalies</li>
<li><strong>Accessibility:</strong> Describing images for visually impaired users</li>
<li><strong>Robotics:</strong> Language-guided manipulation and navigation</li>
</ul>

<h2>Challenges</h2>
<ul>
<li><strong>Data scarcity:</strong> Paired multimodal data is harder to collect than text</li>
<li><strong>Alignment:</strong> Ensuring concepts mean the same thing across modalities</li>
<li><strong>Hallucination:</strong> Models may invent visual details not present in images</li>
<li><strong>Bias:</strong> Training data biases manifest differently across modalities</li>
</ul>
HTML;
    }

    private function content18(): string
    {
        return <<<'HTML'
<p>Caching is one of the most effective ways to improve application performance. But caching is not just about slapping Redis in front of your database. Effective caching requires understanding access patterns, consistency requirements, and eviction strategies.</p>

<h2>Cache Layers</h2>

<h3>Browser Cache</h3>
<p>The closest cache to the user. Controlled via HTTP headers:</p>
<ul>
<li><code>Cache-Control: max-age=3600</code> — cache for 1 hour</li>
<li><code>ETag</code> — validate cache freshness with content hash</li>
<li><code>Last-Modified</code> — conditional requests based on modification time</li>
</ul>

<h3>CDN Cache</h3>
<p>Content Delivery Networks cache static assets at edge locations. Dynamic content can also be cached with proper cache keys and TTLs. Services like Cloudflare and Fastly offer programmable edge caching.</p>

<h3>Application Cache</h3>
<p>In-memory caches like Redis or Memcached store hot data. Used for:</p>
<ul>
<li>Session storage</li>
<li>Database query results</li>
<li>Rate limit counters</li>
<li>Feature flags</li>
</ul>

<h3>Database Cache</h3>
<p>Modern databases have built-in caches. PostgreSQL uses shared_buffers; MySQL uses the InnoDB buffer pool. Tuning these is often the first optimization step.</p>

<h2>Cache Patterns</h2>

<h3>Cache-Aside (Lazy Loading)</h3>
<p>The application checks the cache first. On miss, it loads from the database and populates the cache.</p>
<pre><code>value = cache.get(key)
if value is None:
    value = db.query(key)
    cache.set(key, value, ttl=300)
return value</code></pre>

<h3>Write-Through</h3>
<p>Data is written to both cache and database synchronously. The cache always has the latest data, but writes are slower.</p>

<h3>Write-Behind (Write-Back)</h3>
<p>Data is written to cache and asynchronously flushed to the database. Maximizes write performance but risks data loss.</p>

<h3>Read-Through</h3>
<p>The cache itself handles misses by loading from the backing store. Simplifies application code.</p>

<h2>Cache Invalidation</h2>
<p>Cache invalidation is famously one of the hard problems in computer science:</p>
<ul>
<li><strong>Time-based (TTL):</strong> Simple but data can be stale</li>
<li><strong>Event-based:</strong> Invalidate on data changes. Requires message bus.</li>
<li><strong>Version-based:</strong> Embed version in key. Old versions naturally expire.</li>
</ul>

<h2>Eviction Policies</h2>
<p>When cache is full, what stays and what goes?</p>
<ul>
<li><strong>LRU (Least Recently Used):</strong> Good default for most workloads</li>
<li><strong>LFU (Least Frequently Used):</strong> Better when access patterns are stable</li>
<li><strong>TTL:</strong> Evict expired entries first</li>
<li><strong>Random:</strong> Surprisingly effective and simple to implement</li>
</ul>

<h2>Cache Warming</h2>
<p>Pre-populate the cache before traffic hits. Essential after deployments or cache failures. Use background jobs to warm critical paths.</p>

<h2>Pitfalls</h2>
<ul>
<li><strong>Thundering herd:</strong> Multiple requests hit a cold cache simultaneously. Use locks or single-flight patterns.</li>
<li><strong>Cache stampede:</strong> Mass expiration causes database overload. Add jitter to TTLs.</li>
<li><strong>Over-caching:</strong> Caching highly dynamic or rarely accessed data wastes memory.</li>
</ul>
HTML;
    }

    private function content19(): string
    {
        return <<<'HTML'
<p>Large Language Models with billions of parameters require massive GPU memory for inference. Model quantization reduces the precision of weights from 32-bit or 16-bit floating point to 8-bit, 4-bit, or even lower—enabling these models to run on consumer hardware.</p>

<h2>Why Quantization Works</h2>
<p>Neural network weights have a distribution with significant redundancy. Research shows that 4-bit precision often captures 95%+ of model quality. The key insight is that you do not need full 32-bit precision for inference—lower precision representations are sufficient.</p>

<h2>Quantization Types</h2>

<h3>Post-Training Quantization (PTQ)</h3>
<p>Quantize a pre-trained model without retraining. Fast and easy but may lose accuracy.</p>

<h3>Quantization-Aware Training (QAT)</h3>
<p>Simulate quantization during training so the model learns to be robust to lower precision. More accurate but requires training from scratch or fine-tuning.</p>

<h2>Common Formats</h2>

<h3>INT8</h3>
<p>The most widely supported format. Reduces memory by 4x compared to FP32 with minimal accuracy loss. Supported by NVIDIA TensorRT, ONNX Runtime, and most inference engines.</p>

<h3>INT4 / FP4</h3>
<p>Used by GPTQ and AWQ. Reduces memory by 8x. Requires careful calibration but enables 70B models on 24GB GPUs.</p>

<h3>GGUF (formerly GGML)</h3>
<p>A binary format for quantized models popularized by llama.cpp. Supports various quantization schemes:</p>
<ul>
<li>Q4_0, Q4_1: 4-bit with different trade-offs</li>
<li>Q5_0, Q5_1: 5-bit for better quality</li>
<li>Q8_0: 8-bit, near-unquantized quality</li>
</ul>

<h2>Key Techniques</h2>

<h3>GPTQ</h3>
<p>Group-wise quantization that minimizes error by considering layer output. Uses approximate second-order information to select optimal quantization parameters.</p>

<h3>AWQ (Activation-Aware Weight Quantization)</h3>
<p>Protects "salient" weights—those most important for model accuracy—by using activation magnitudes as a proxy for weight importance. Often outperforms GPTQ with less calibration data.</p>

<h3>SmoothQuant</h3>
<p>Migrates quantization difficulty from activations to weights via mathematically equivalent transformations. Particularly effective for difficult-to-quantize models.</p>

<h2>Practical Considerations</h2>
<ul>
<li><strong>Calibration data:</strong> PTQ methods need representative samples. Use 128-512 examples from your target domain.</li>
<li><strong>Batch size:</strong> Larger batches amplify quantization error in activations.</li>
<li><strong>Hardware support:</strong> Not all GPUs efficiently support INT4. Check your hardware's tensor core capabilities.</li>
</ul>

<h2>Quality vs Size Trade-off</h2>
<table>
<thead><tr><th>Format</th><th>Size (70B)</th><th>Quality</th><th>Hardware</th></tr></thead>
<tbody>
<tr><td>FP16</td><td>140 GB</td><td>100%</td><td>8x A100</td></tr>
<tr><td>INT8</td><td>70 GB</td><td>~99%</td><td>4x A100</td></tr>
<tr><td>Q4_K_M</td><td>42 GB</td><td>~97%</td><td>2x A100 or 1x A6000</td></tr>
<tr><td>Q4_0</td><td>39 GB</td><td>~95%</td><td>1x A6000</td></tr>
</tbody>
</table>
HTML;
    }

    private function content20(): string
    {
        return <<<'HTML'
<p>Deploying machine learning models to production is fundamentally different from deploying traditional software. Models degrade over time, data distributions shift, and inference requirements change. MLOps brings the rigor of DevOps to machine learning.</p>

<h2>The MLOps Lifecycle</h2>
<ol>
<li><strong>Data Collection:</strong> Gathering, labeling, and validating training data</li>
<li><strong>Experimentation:</strong> Training and evaluating models</li>
<li><strong>Model Registry:</strong> Versioning and tracking model artifacts</li>
<li><strong>CI/CD:</strong> Automating testing and deployment</li>
<li><strong>Serving:</strong> Deploying models for inference</li>
<li><strong>Monitoring:</strong> Tracking performance, data drift, and latency</li>
<li><strong>Retraining:</strong> Updating models when performance degrades</li>
</ol>

<h2>CI/CD for ML</h2>
<p>Traditional CI/CD pipelines test code. ML pipelines must also test <em>data</em> and <em>models</em>:</p>

<h3>Data Validation</h3>
<ul>
<li>Schema checks (column names, types, ranges)</li>
<li>Distribution checks (prevent training-serving skew)</li>
<li>Anomaly detection for incoming data</li>
</ul>

<h3>Model Testing</h3>
<ul>
<li>Unit tests for preprocessing code</li>
<li>Integration tests for the full pipeline</li>
<li>Model performance benchmarks on holdout sets</li>
<li>Fairness and bias checks</li>
</ul>

<h3>Pipeline Orchestration</h3>
<p>Tools like Kubeflow Pipelines, MLflow, and Apache Airflow define DAGs of ML steps:</p>
<pre><code>Data Ingestion → Validation → Transformation → Training → Evaluation → Deployment</code></pre>

<h2>Model Serving Patterns</h2>

<h3>Real-Time Serving</h3>
<p>Deploy models as REST/gRPC APIs. Use model servers like TensorFlow Serving, TorchServe, or Triton Inference Server. Optimize with:</p>
<ul>
<li>Batching requests dynamically</li>
<li>Quantization and pruning</li>
<li>GPU utilization optimization</li>
</ul>

<h3>Batch Prediction</h3>
<p>For non-time-sensitive tasks, run predictions on schedules using Spark, AWS Batch, or Kubernetes Jobs. More cost-effective for large volumes.</p>

<h3>Edge Deployment</h3>
<p>Deploy lightweight models to mobile devices or IoT. Use ONNX Runtime, TensorFlow Lite, or Core ML. Quantization and distillation are essential here.</p>

<h2>Monitoring ML in Production</h2>

<h3>Model Performance</h3>
<p>Track accuracy, precision, recall, or business metrics. But ground truth labels often arrive with delay—you need proxy metrics.</p>

<h3>Data Drift</h3>
<p>When input data distribution changes, model performance degrades. Monitor:</p>
<ul>
<li><strong>Feature drift:</strong> Statistical divergence in input distributions</li>
<li><strong>Prediction drift:</strong> Changes in model output distributions</li>
<li><strong>Label drift:</strong> Changes in ground truth distribution</li>
</ul>

<h3>Concept Drift</h3>
<p>The relationship between inputs and outputs changes. This is harder to detect and may require periodic retraining or online learning.</p>

<h2>Tools of the Trade</h2>
<table>
<thead><tr><th>Category</th><th>Tools</th></tr></thead>
<tbody>
<tr><td>Experiment Tracking</td><td>Weights & Biases, MLflow, Neptune</td></tr>
<tr><td>Pipeline Orchestration</td><td>Kubeflow, Airflow, Prefect</td></tr>
<tr><td>Model Registry</td><td>MLflow Model Registry, DVC</td></tr>
<tr><td>Feature Store</td><td>Feast, Tecton, SageMaker Feature Store</td></tr>
<tr><td>Monitoring</td><td>Evidently, WhyLabs, Arize</td></tr>
<tr><td>Serving</td><td>Seldon, BentoML, KServe</td></tr>
</tbody>
</table>

<h2>From Notebook to Production</h2>
<p>The biggest MLOps challenge is not tooling—it is culture. Ensure reproducibility by pinning dependencies, versioning data, and automating every step from experiment to deployment. A model that only works in a Jupyter notebook is not a production model.</p>
HTML;
    }
}
